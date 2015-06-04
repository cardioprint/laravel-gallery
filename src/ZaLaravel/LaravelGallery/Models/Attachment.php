<?php

namespace App\Models;


use ZaLaravel\LaravelGallery\Models\Interfaces\AttachmentInterface;

class Attachment extends File implements UploadInterface, AttachmentInterface
{
    
    protected $table = 'attachment';

    protected $uploadPath = '/uploads/attachments/';

    protected $fillable = [];


}
