<?php

namespace ZaLaravel\LaravelGallery\Models;

use Illuminate\Database\Eloquent\Model;
use ZaLaravel\LaravelGallery\Models\Interfaces\GalleryAttachmentInterface;
use ZaLaravel\LaravelGallery\Models\Interfaces\UploadInterface;

class GalleryAttachment extends File implements UploadInterface, GalleryAttachmentInterface{

    protected $fillable = ['comment', 'link'];

}
