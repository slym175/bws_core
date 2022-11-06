<?php

namespace Bws\Media\Http\Controllers;

use Bws\Media\Http\Requests\MediaFolderRequest;
use Bws\Media\Repositories\Interfaces\MediaFileInterface;
use Bws\Media\Repositories\Interfaces\MediaFolderInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * @since 19/08/2015 07:55 AM
 */
class MediaFolderController extends Controller
{
    /**
     * @var MediaFolderInterface
     */
    protected $folderRepository;

    /**
     * @var MediaFileInterface
     */
    protected $fileRepository;

    /**
     * FolderController constructor.
     * @param MediaFolderInterface $folderRepository
     * @param MediaFileInterface $fileRepository
     */
    public function __construct(MediaFolderInterface $folderRepository, MediaFileInterface $fileRepository)
    {
        $this->folderRepository = $folderRepository;
        $this->fileRepository = $fileRepository;
    }

    /**
     * @param MediaFolderRequest $request
     * @return JsonResponse
     */
    public function store(MediaFolderRequest $request)
    {
        $name = $request->input('name');

        try {
            $parentId = $request->input('parent_id');

            $folder = $this->folderRepository->getModel();
            if(auth('web')->check())
                $folder->user_id = auth('web')->user()->id;
            $folder->name = $this->folderRepository->createName($name, $parentId);
            $folder->slug = $this->folderRepository->createSlug($name, $parentId);
            $folder->parent_id = $parentId;
            $this->folderRepository->createOrUpdate($folder);

            return bws_media()->responseSuccess([], trans('bws/media::media.folder_created'));
        } catch (\Exception $exception) {
            return bws_media()->responseError($exception->getMessage());
        }
    }
}
