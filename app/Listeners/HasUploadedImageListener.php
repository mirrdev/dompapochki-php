<?php
namespace App\Listeners;
use App\Helpers\ImageHelper;
use Intervention\Image\ImageManagerStatic as Image;
use Unisharp\Laravelfilemanager\Events\ImageWasUploaded;

class HasUploadedImageListener
{
    public $width = 0;
    public $height = 0;

    public function handle($event)
    {
        $method = 'on'.class_basename($event);
        if (method_exists($this, $method)) {
            call_user_func([$this, $method], $event);
        }
    }

    /**
     * Handle the event.
     *
     * @param  ImageWasUploaded  $event
     * @return void
     */

    public function onImageWasUploaded(ImageWasUploaded $event)
    {
        $realPath = $event->path();

        $this->width = Image::make($realPath)->width();
        $this->height = Image::make($realPath)->height();

        $paths = [
            [
                'type' => 'small',
                'width' => 400,
                'height' => 300,
            ],
            [
                'type' => 'middle',
                'width' => 700,
                'height' => 500,
            ],
            [
                'type' => 'large',
                'width' => 1000,
                'height' => 700,
            ],

            [
                'type' => 'slider',
                'width' => 1280,
                'height' => 600,
            ],
            [
                'type' => 'product',
                'width' => 600,
                'height' => 400,
            ],
            [
                'type' => 'product-long',
                'width' => 600,
                'height' => 250,
            ]
        ];

        foreach ($paths as $path)
        {
            $filepathNew = ImageHelper::getThumbPath($realPath, $path['type']);

            $img = Image::make($realPath);

//            list($widthCrop, $heightCrop, $xCrop, $yCrop) = $this->getCropData($path);
//            $img->crop($widthCrop, $heightCrop, $xCrop, $yCrop);

            $img->fit($path['width'], $path['height']);

            $img->save($filepathNew);
        }
    }

    private function getCropData($path)
    {
        $heightCrop = 0;
        $widthCrop = 0;
        $xCrop = 0;
        $yCrop = 0;

        if($path['height'] >= $path['width'])
        {
            $heightCrop = $this->height;
            $widthCrop = $path['width'] * ($this->height / $heightCrop);
            $xCrop = ($this->width - $widthCrop) / 2;
            $yCrop = 0;

            if($widthCrop > $this->width)
            {
                $widthCrop = $this->width;
                $heightCrop = $path['height'] * ($this->width / $widthCrop);
                $xCrop = 0;
                $yCrop = ($this->height - $heightCrop) / 2;
            }
        }
        if($path['height'] < $path['width'])
        {
            $widthCrop = $this->width;
            $heightCrop = $path['height'] * ($this->width / $widthCrop);
            $xCrop = 0;
            $yCrop = ($this->height - $heightCrop) / 2;

            if ($heightCrop > $this->height)
            {
                $heightCrop = $this->height;
                $widthCrop = $path['width'] * ($this->height / $heightCrop);
                $xCrop = ($this->width - $widthCrop) / 2;
                $yCrop = 0;
            }
        }
        return [
            $heightCrop,
            $widthCrop,
            $xCrop,
            $yCrop
        ];
    }
}