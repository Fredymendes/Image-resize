<?php

use Imagine\Gd\Image;

require_once __DIR__ . '/vendor/autoload.php';

class ImageResize
{
    public $imagine;

    public function __construct()
    {
        $this->imagine = new \Imagine\Gd\Imagine();
    }

    public function resizeAllImages($dir)
    {
        $files = scandir($dir);

        foreach ($files as $key => $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                //Resize image
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                if (in_array($ext, ['jpg', 'png', 'jpeg'])) {
                    $this->imagine->open($path)
                    ->thumbnail(new \Imagine\Image\Box(1920, 1080))
                    ->save($path);
                }
            } elseif ($value != "." && $value != "..") {
                $this->resizeAllImages($path);
            }
        }
    }
}

$resizer = new ImageResize();
$resizer->resizeAllImages("./images");
