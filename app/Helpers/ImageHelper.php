<?php

namespace App\Helpers;


class ImageHelper
{
    public static function getThumbURL($fullFileUrl, $thumbSize, $thumbFolder = 'thumbs')
    {
        return self::getThumb($fullFileUrl, $thumbSize, $thumbFolder);
    }

    public static function getThumbPath($fullFileUrl, $thumbSize, $thumbFolder = 'thumbs')
    {
        return self::getThumb($fullFileUrl, $thumbSize, $thumbFolder);
    }

    protected static function getThumb($fullFileUrl, $thumbSize, $thumbFolder)
    {
        $name = self::getName($fullFileUrl);
        $path = self::getPath($fullFileUrl);
        $thumbName = self::getNameThumb($name, $thumbSize);
        $thumbsFullUrl = $path . '/' . $thumbFolder . $thumbName;

        return $thumbsFullUrl;
    }

    protected static function getPath($pathOrUrl)
    {
        $imagePathArray = explode('/', $pathOrUrl);
        array_pop($imagePathArray);
        return implode('/', $imagePathArray);
    }
    protected static function getName($pathOrUrl)
    {
        $path = self::getPath($pathOrUrl);
        return str_replace($path, '', $pathOrUrl);
    }

    private static function getNameThumb($name, $thumbSize)
    {
        $fileArray = explode('.', $name);
        $format = array_pop($fileArray);
        $newName = implode('.', $fileArray);
        $newName .= '_' .$thumbSize . '.' . $format;

        return $newName;
    }
}