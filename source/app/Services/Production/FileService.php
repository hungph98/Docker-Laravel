<?php

namespace App\Services\Production;

use App\Services\Contracts\FileServiceInterface;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Psr\Http\Message\StreamInterface;

class FileService implements FileServiceInterface
{
    /**
     * Parameter
     *
     * @param $file
     * @param $path
     * @return String
     */
    public function upload($file, $path)
    {
        return Storage::disk(env('STORAGE_DISK'))->putFile($path, $file);
    }

    /**
     * Function delete image
     *
     * @param array $images
     * @return bool
     */
    public function delete($images = [])
    {
        return Storage::disk(env('STORAGE_DISK'))->delete($images);
    }

    /**
     * Function check image exists
     *
     * @param $path
     * @return bool
     */
    public function exists($path)
    {
        return Storage::disk(env('STORAGE_DISK'))->exists($path);
    }

    /**
     * Function store file
     *
     * @param $path
     * @param $file
     * @return String
     */
    public function storeFile($path, $file)
    {
        return Storage::disk(env('STORAGE_DISK'))->put($path, $file);
    }

    /**
     * Function copy file
     *
     * @param $imageOld
     * @param $imageNew
     */
    public function copy($imageOld, $imageNew)
    {
        return Storage::disk(env('STORAGE_DISK'))->copy($imageOld, $imageNew);
    }

    /**
     * Function move file
     *
     * @param $imageOld
     * @param $imageNew
     */
    public function move($imageOld, $imageNew)
    {
        return Storage::disk(env('STORAGE_DISK'))->move($imageOld, $imageNew);
    }

    /**
     * Resize image with the width and height
     *
     * @param $file
     * @param bool $isThumbnail
     * @return StreamInterface
     * @SuppressWarnings(PHPMD.ElseExpression)
     */
    public function resize($file, $thumbnailHeight, $imageHeight, $thumbnailWidth, $imageWidth, $isThumbnail = false)
    {
        $image = Image::make($file);
        $originalHeight = $image->height();
        $originalWidth = $image->width();
        $resizeHeight = $isThumbnail ? $thumbnailHeight : $imageHeight;
        $resizeWidth = $isThumbnail ? $thumbnailWidth : $imageWidth;
        if ($originalHeight < $originalWidth) {
            $resizeWidth = $resizeHeight * $originalWidth / $originalHeight;
            $image->resize($resizeWidth, $resizeHeight);
        } else {
            $resizeHeight = $resizeWidth * $originalHeight / $originalWidth;
            $image->resize($resizeWidth, $resizeHeight);
        }
        return $image->stream();
    }
}
