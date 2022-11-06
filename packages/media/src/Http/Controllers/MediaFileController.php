<?php

namespace Bws\Media\Http\Controllers;

use Bws\Media\Chunks\Exceptions\UploadMissingFileException;
use Bws\Media\Chunks\Handler\DropZoneUploadHandler;
use Bws\Media\Chunks\Receiver\FileReceiver;
use Bws\Media\Repositories\Interfaces\MediaFileInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

/**
 * @since 19/08/2015 07:50 AM
 */
class MediaFileController extends Controller
{
    protected $fileRepository;

    public function __construct(MediaFileInterface $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function postUpload(Request $request)
    {
        if (!bws_media()->isChunkUploadEnabled()) {
            $result = bws_media()->handleUpload(Arr::first($request->file('file')), $request->input('folder_id', 0));

            return $this->handleUploadResponse($result);
        }

        try {
            // Create the file receiver
            $receiver = new FileReceiver('file', $request, DropZoneUploadHandler::class);
            // Check if the upload is success, throw exception or return response you need
            if ($receiver->isUploaded() === false) {
                throw new UploadMissingFileException;
            }
            // Receive the file
            $save = $receiver->receive();
            // Check if the upload has finished (in chunk mode it will send smaller files)
            if ($save->isFinished()) {
                $result = bws_media()->handleUpload($save->getFile(), $request->input('folder_id', 0));

                return $this->handleUploadResponse($result);
            }
            // We are in chunk mode, lets send the current progress
            $handler = $save->handler();

            return response()->json([
                'done'   => $handler->getPercentageDone(),
                'status' => true,
            ]);
        } catch (\Exception $exception) {
            return bws_media()->responseError($exception->getMessage());
        }
    }

    protected function handleUploadResponse(array $result)
    {
        if ($result['error'] == false) {
            return bws_media()->responseSuccess([
                'id'  => $result['data']->id,
                'src' => bws_media()->url($result['data']->url),
            ]);
        }

        return bws_media()->responseError($result['message']);
    }

    public function postUploadFromEditor(Request $request)
    {
        return bws_media()->uploadFromEditor($request);
    }

    public function postDownloadUrl(Request $request)
    {
        $validator = Validator::make($request->input(), [
            'url' => 'required',
        ]);

        if ($validator->fails()) {
            return bws_media()->responseError($validator->messages()->first());
        }

        $result = bws_media()->uploadFromUrl($request->input('url'), $request->input('folderId'));

        if ($result['error'] == false) {
            return bws_media()->responseSuccess([
                'id'        => $result['data']->id,
                'src'       => Storage::url($result['data']->url),
                'url'       => $result['data']->url,
                'message'   => trans('core/media::media.javascript.message.success_header')
            ]);
        }

        return bws_media()->responseError($result['message']);
    }
}
