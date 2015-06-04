<?php

namespace ZaLaravel\LaravelGallery\Facades;

use Illuminate\Support\Facades\Facade;
use ZaLaravel\LaravelGallery\Services\ImageUploadService;

class ImageUploadFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return new ImageUploadService();
    }

}