<?php

namespace Bws\Media\Repositories\Caches;

use Bws\Media\Repositories\Interfaces\MediaFileInterface;

class MediaFileCacheDecorator extends CacheAbstractDecorator implements MediaFileInterface
{
    /**
     * {@inheritDoc}
     */
    public function createName($name, $folder)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function createSlug($name, $extension, $folder)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getFilesByFolderId($folderId, array $params = [], $withFolders = true, $folderParams = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function emptyTrash()
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getTrashed($folderId, array $params = [], $withFolders = true, $folderParams = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
