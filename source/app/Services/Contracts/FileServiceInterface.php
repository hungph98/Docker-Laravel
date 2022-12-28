<?php

namespace App\Services\Contracts;

interface FileServiceInterface
{
    public function upload($file, $path);

    public function delete($model);

    public function exists($path);

    public function storeFile($path, $file);

    public function copy($imageOld, $imageNew);

    public function move($imageOld, $imageNew);

    public function resize($file, $thumbnailHeight, $imageHeight, $thumbnailWidth, $imageWidth, $isThumbnail = false);
}
