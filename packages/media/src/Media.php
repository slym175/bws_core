<?php

namespace Bws\Media;

use Bws\Media\Http\Resources\FileResource;
use Bws\Media\Models\MediaFile;
use Bws\Media\Repositories\Interfaces\MediaFileInterface;
use Bws\Media\Repositories\Interfaces\MediaFolderInterface;
use Bws\Media\Services\ThumbnailService;
use Bws\Media\Services\UploadsManager;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mimey\MimeTypes;

class Media
{
    protected $permissions = [];
    protected $uploadManager;
    protected $fileRepository;
    protected $folderRepository;
    protected $thumbnailService;

    public function __construct(
        MediaFileInterface $fileRepository,
        MediaFolderInterface $folderRepository,
        UploadsManager $uploadManager,
        ThumbnailService $thumbnailService
    ) {
        $this->fileRepository = $fileRepository;
        $this->folderRepository = $folderRepository;
        $this->uploadManager = $uploadManager;
        $this->thumbnailService = $thumbnailService;

        $this->permissions = $this->getConfig('permissions', []);
    }

    public function url($path): string
    {
        $path = trim($path);

        if (Str::contains($path, 'https://') || Str::contains($path, 'http://')) {
            return $path;
        }

        return Storage::url($path);
    }

    public function getUrls(): array
    {
        return [
            'base_url'                 => url(''),
            'base'                     => route('admin.media.index'),
            'get_media'                => route('admin.media.list'),
            'create_folder'            => route('admin.media.folders.create'),
            'popup'                    => route('admin.media.popup'),
            'download'                 => route('admin.media.download'),
            'upload_file'              => route('admin.media.files.upload'),
            'get_breadcrumbs'          => route('admin.media.breadcrumbs'),
            'global_actions'           => route('admin.media.global_actions'),
            'media_upload_from_editor' => route('admin.media.files.upload.from.editor'),
            'download_url'             => route('admin.media.download_url'),
        ];
    }

    public function renderHeader(): string
    {
        $urls = $this->getUrls();

        return view('bws@media::header', compact('urls'))->render();
    }

    public function renderFooter(): string
    {
        return view('bws@media::footer')->render();
    }

    public function renderContent(): string
    {
        return view('bws@media::content')->render();
    }

    public function getConfig($key = null, $default = null)
    {
        $configs = config('bws@media.media.bws-media');
        if (!$key) {
            return $configs;
        }

        return Arr::get($configs, $key, $default);
    }

    public static function responseSuccess($data, $message = null): JsonResponse
    {
        return response()->json([
            'error'   => false,
            'data'    => $data,
            'message' => $message,
        ]);
    }

    public static function responseError($message, $data = [], $code = null, $status = 200): JsonResponse
    {
        return response()->json([
            'error'   => true,
            'message' => $message,
            'data'    => $data,
            'code'    => $code,
        ], $status);
    }

    /**
     * @param string $url
     * @return string
     */
    public function getRealPath($url)
    {
        switch (config('filesystems.default')) {
            case 'local':
            case 'public':
                return Storage::path($url);
            case 's3':
                return Storage::url($url);
        }

        return Storage::path($url);
    }

    public function isChunkUploadEnabled()
    {
        return $this->getConfig('chunk.enabled') == '1';
    }

    public function handleTargetFolder($folderId = 0, $filePath = ''): string
    {
        if (strpos($filePath, '/') !== false) {
            $paths = explode('/', $filePath);
            array_pop($paths);
            foreach ($paths as $folder) {
                $folderId = $this->createFolder($folder, $folderId);
            }
        }

        return $folderId;
    }

    public function createFolder($folderSlug, $parentId = 0)
    {
        $folder = $this->folderRepository->getFirstBy(['media_folders.slug' => $folderSlug]);


        if (!$folder) {
            $folder = $this->folderRepository->createOrUpdate([
                'user_id'   => Auth::check() ? Auth::id() : 0,
                'name'      => $this->folderRepository->createName($folderSlug, 0),
                'slug'      => $this->folderRepository->createSlug($folderSlug, 0),
                'parent_id' => $parentId,
            ]);
        }

        return $folder->id;
    }

    public function getAllImageSizes($url): array
    {
        $images = [];
        foreach ($this->getSizes() as $size) {
            $readableSize = explode('x', $size);
            $images = $this->getImageUrl($url, $readableSize);
        }

        return $images;
    }

    public function getSizes(): array
    {
        return $this->getConfig('sizes', []);
    }

    public function getImageUrl($url, $size = null, $relativePath = false, $default = null)
    {
        $url = trim($url);

        if (empty($url)) {
            return $default;
        }

        if (empty($size) || $url == '__value__') {
            if ($relativePath) {
                return $url;
            }

            return $this->url($url);
        }

        if ($url == $this->getDefaultImage()) {
            return url($url);
        }

        if ($size &&
            array_key_exists($size, $this->getSizes()) &&
            $this->canGenerateThumbnails($this->getMimeType($url))
        ) {
            $url = str_replace(
                File::name($url) . '.' . File::extension($url),
                File::name($url) . '-' . $this->getSize($size) . '.' . File::extension($url),
                $url
            );
        }

        if ($relativePath) {
            return $url;
        }

        if ($url == '__image__') {
            return $this->url($default);
        }

        return $this->url($url);
    }

    public function getDefaultImage(bool $relative = false): string
    {
        $default = $this->getConfig('default_image');

        if ($relative) {
            return $default;
        }

        return $default ? url($default) : $default;
    }

    public function getSize(string $name): ?string
    {
        return $this->getConfig('sizes.' . $name);
    }

    public function deleteFile(MediaFile $file): bool
    {
        $this->deleteThumbnails($file);

        return Storage::delete($file->url);
    }

    public function deleteThumbnails(MediaFile $file): bool
    {
        if (!$file->canGenerateThumbnails()) {
            return false;
        }

        $filename = pathinfo($file->url, PATHINFO_FILENAME);

        $files = [];
        foreach ($this->getSizes() as $size) {
            $files[] = str_replace($filename, $filename . '-' . $size, $file->url);
        }

        return Storage::delete($files);
    }

    public function getPermissions(): array
    {
        return $this->permissions;
    }

    public function setPermissions(array $permissions)
    {
        $this->permissions = $permissions;
    }

    public function removePermission($permission)
    {
        Arr::forget($this->permissions, $permission);
    }

    public function addPermission($permission)
    {
        $this->permissions[] = $permission;
    }

    public function hasPermission($permission): bool
    {
        return in_array($permission, $this->permissions);
    }

    public function hasAnyPermission(array $permissions): bool
    {
        $hasPermission = false;
        foreach ($permissions as $permission) {
            if (in_array($permission, $this->permissions)) {
                $hasPermission = true;
                break;
            }
        }

        return $hasPermission;
    }

    public function addSize(string $name, $width, $height = 'auto'): self
    {
        config(['packages.media.bws-media.sizes.' . $name => $width . 'x' . $height]);

        return $this;
    }

    public function removeSize(string $name): self
    {
        $sizes = $this->getSizes();
        Arr::forget($sizes, $name);

        config(['core.media.media.sizes' => $sizes]);

        return $this;
    }

    public function uploadFromEditor(Request $request, $folderId = 0, $folderName = null, $fileInput = 'upload')
    {
        $validator = Validator::make($request->all(), [
            'upload' => $this->imageValidationRule(),
        ]);

        if ($validator->fails()) {
            return response('<script>alert("' . trans('bws/media::media.can_not_detect_file_type') . '")</script>')
                ->header('Content-Type', 'text/html');
        }

        $folderName = $folderName ?: $request->input('upload_type');

        $result = $this->handleUpload($request->file($fileInput), $folderId, $folderName);

        if ($result['error'] == false) {
            $file = $result['data'];
            if (!$request->input('CKEditorFuncNum')) {
                return response()->json([
                    'fileName' => File::name($this->url($file->url)),
                    'uploaded' => 1,
                    'url'      => $this->url($file->url),
                ]);
            }

            return response('<script>window.parent.CKEDITOR.tools.callFunction("' . $request->input('CKEditorFuncNum') .
                '", "' . $this->url($file->url) . '", "");</script>')
                ->header('Content-Type', 'text/html');
        }

        return response('<script>alert("' . Arr::get($result, 'message') . '")</script>')
            ->header('Content-Type', 'text/html');
    }

    public function humanFilesize(int $bytes, int $precision = 2)
    {
        $units = ['B', 'kB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return number_format($bytes, $precision, ',', '.') . ' ' . $units[$pow];
    }

    public function handleUpload($fileUpload, $folderId = 0, $folderSlug = null, $skipValidation = false): array
    {
        $request = request();

        if ($request->input('path')) {
            $folderId = $this->handleTargetFolder($folderId, $request->input('path'));
        }

        if (!$fileUpload) {
            return [
                'error'   => true,
                'message' => trans('core/media::media.can_not_detect_file_type'),
            ];
        }

        $allowedMimeTypes = $this->getConfig('allowed_mime_types');

        if (!$this->isChunkUploadEnabled()) {
            $request->merge(['uploaded_file' => $fileUpload]);

            if (!$skipValidation) {
                $validator = Validator::make($request->all(), [
                    'uploaded_file' => 'required|mimes:' . $allowedMimeTypes,
                ]);

                if ($validator->fails()) {
                    return [
                        'error'   => true,
                        'message' => $validator->getMessageBag()->first(),
                    ];
                }
            }

            $request->offsetUnset('uploaded_file');

            $maxSize = $this->getServerConfigMaxUploadFileSize();

            if ($fileUpload->getSize() / 1024 > (int)$maxSize) {
                return [
                    'error'   => true,
                    'message' => trans('core/media::media.file_too_big', ['size' => $this->humanFilesize($maxSize)]),
                ];
            }
        }

        try {
            $file = $this->fileRepository->getModel();

            $fileExtension = $fileUpload->getClientOriginalExtension();

            if (!$skipValidation && !in_array(strtolower($fileExtension), explode(',', $allowedMimeTypes))) {
                return [
                    'error'   => true,
                    'message' => trans('bws/media::media.can_not_detect_file_type'),
                ];
            }

            if ($folderId == 0 && !empty($folderSlug)) {
                $folder = $this->folderRepository->getFirstBy(['media_folders.slug' => $folderSlug]);

                if (!$folder) {
                    $folder = $this->folderRepository->createOrUpdate([
                        'user_id'   => Auth::check() ? Auth::id() : 0,
                        'name'      => $this->folderRepository->createName($folderSlug, 0),
                        'slug'      => $this->folderRepository->createSlug($folderSlug, 0),
                        'parent_id' => 0,
                    ]);
                }

                $folderId = $folder->id;
            }

            $file->name = $this->fileRepository->createName(
                File::name($fileUpload->getClientOriginalName()),
                $folderId
            );

            $folderPath = $this->folderRepository->getFullPath($folderId);

            $fileName = $this->fileRepository->createSlug(
                $file->name,
                $fileExtension,
                Storage::path($folderPath)
            );

            $filePath = $fileName;

            if ($folderPath) {
                $filePath = $folderPath . '/' . $filePath;
            }

            $content = File::get($fileUpload->getRealPath());

            $this->uploadManager->saveFile($filePath, $content, $fileUpload);

            $data = $this->uploadManager->fileDetails($filePath);

            if (!$skipValidation && empty($data['mime_type'])) {
                return [
                    'error'   => true,
                    'message' => trans('bws/media::media.can_not_detect_file_type'),
                ];
            }

            $file->url = $data['url'];
            $file->size = $data['size'];
            $file->mime_type = $data['mime_type'];
            $file->folder_id = $folderId;
            $file->user_id = Auth::check() ? Auth::id() : 0;
            $file->options = $request->input('options', []);
            $file = $this->fileRepository->createOrUpdate($file);

            $this->generateThumbnails($file);

            return [
                'error' => false,
                'data'  => new FileResource($file),
            ];
        } catch (\Exception $exception) {
            return [
                'error'   => true,
                'message' => $exception->getMessage(),
            ];
        }
    }

    public function getServerConfigMaxUploadFileSize()
    {
        // Start with post_max_size.
        $maxSize = $this->parseSize(ini_get('post_max_size'));

        // If upload_max_size is less, then reduce. Except if upload_max_size is
        // zero, which indicates no limit.
        $uploadMax = $this->parseSize(ini_get('upload_max_filesize'));
        if ($uploadMax > 0 && $uploadMax < $maxSize) {
            $maxSize = $uploadMax;
        }

        return $maxSize;
    }

    public function parseSize($size)
    {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
        $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
        if ($unit) {
            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        }

        return round($size);
    }

    public function generateThumbnails(MediaFile $file): bool
    {
        if (!$file->canGenerateThumbnails()) {
            return false;
        }

        foreach ($this->getSizes() as $size) {
            $readableSize = explode('x', $size);

            $this->thumbnailService
                ->setImage($this->getRealPath($file->url))
                ->setSize($readableSize[0], $readableSize[1])
                ->setDestinationPath(File::dirname($file->url))
                ->setFileName(File::name($file->url) . '-' . $size . '.' . File::extension($file->url))
                ->save();
        }

        return true;
    }

    public function isImage($mimeType)
    {
        return Str::startsWith($mimeType, 'image/');
    }

    public function isUsingCloud(): bool
    {
        return !in_array(config('filesystems.default'), ['local', 'public']);
    }

    public function uploadFromUrl(string $url, int $folderId = 0, ?string $folderSlug = null, $defaultMimetype = null)
    {
        if (empty($url)) {
            return [
                'error'   => true,
                'message' => trans('bws/media::media.url_invalid'),
            ];
        }

        $info = pathinfo($url);

        try {
            $contents = file_get_contents($url);
        } catch (\Exception $exception) {
            return [
                'error'   => true,
                'message' => $exception->getMessage(),
            ];
        }

        if (empty($contents)) {
            return null;
        }

        $path = '/tmp';
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0755);
        }

        $path = $path . '/' . $info['basename'];
        file_put_contents($path, $contents);


        $mimeType = $this->getMimeType($url);

        if (empty($mimeType)) {
            $mimeType = $defaultMimetype;
        }

        $fileName = File::name($info['basename']);
        $fileExtension = File::extension($info['basename']);
        if (empty($fileExtension)) {
            $mimeTypeDetection = new MimeTypes;

            $fileExtension = $mimeTypeDetection->getExtension($mimeType);
        }

        $fileUpload = new UploadedFile($path, $fileName . '.' . $fileExtension, $mimeType, null, true);

        $result = $this->handleUpload($fileUpload, $folderId, $folderSlug);

        File::delete($path);

        return $result;
    }

    public function uploadFromPath(string $path, int $folderId = 0, ?string $folderSlug = null, $defaultMimetype = null)
    {
        if (empty($path)) {
            return [
                'error'   => true,
                'message' => trans('bws/media::media.path_invalid'),
            ];
        }

        $mimeType = $this->getMimeType($path);

        if (empty($mimeType)) {
            $mimeType = $defaultMimetype;
        }

        $fileName = File::name($path);
        $fileExtension = File::extension($path);
        if (empty($fileExtension)) {
            $mimeTypeDetection = new MimeTypes;

            $fileExtension = $mimeTypeDetection->getExtension($mimeType);
        }

        $fileUpload = new UploadedFile($path, $fileName . '.' . $fileExtension, $mimeType, null, true);

        return $this->handleUpload($fileUpload, $folderId, $folderSlug);
    }

    public function getUploadPath(): string
    {
        return public_path('storage');
    }

    public function getUploadURL(): string
    {
        return str_replace('/index.php', '', url('storage'));
    }

    public function getMimeType($url)
    {
        if (!$url) {
            return null;
        }

        $mimeTypeDetection = new MimeTypes;

        return $mimeTypeDetection->getMimeType(File::extension($url));
    }

    public function canGenerateThumbnails($mimeType)
    {
        return $this->isImage($mimeType) && !in_array($mimeType, ['image/svg+xml', 'image/x-icon']);
    }

    public function imageValidationRule()
    {
        return 'required|image|mimes:jpg,jpeg,png,webp';
    }
}
