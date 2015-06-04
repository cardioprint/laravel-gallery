<?php

namespace ZaLaravel\LaravelGallery\Models;

use Illuminate\Database\Eloquent\Model;
use Collective\Annotations\Database\Eloquent\Annotations\Annotations\Bind;
use ZaLaravel\LaravelGallery\Models\Interfaces\GalleryInterface;

/**
 * Class Gallery
 * @package ZaLaravel\LaravelGallery\Models
 * @Bind("gallery")
 */
class Gallery extends Model implements GalleryInterface{

    protected $fillable = ['slug', 'title', 'article', 'description', 'tags'];

    public function attachments(){
        return $this->hasMany('ZaLaravel\LaravelGallery\Models\GalleryAttachment', 'hash' ,'attachment_hash');
    }
}
