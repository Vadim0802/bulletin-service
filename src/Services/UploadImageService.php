<?php

namespace Bodianskii\BulletinService\Services;

use Bodianskii\BulletinService\Models\Image;
use Illuminate\Database\Eloquent\Model;

class UploadImageService
{
    private const ALLOWED_MIME_TYPES = [
        'image/png',
        'image/jpeg'
    ];

    public function store(Model $bulletin, array $files): void
    {
        $root = __DIR__ . '/../../';

        if (! file_exists($root. '/public/' . '/images')) {
            mkdir($root . '/public/' . '/images/');
        }

        foreach ($files as $file) {
            $uid = uniqid();
            $relativePath = 'images/' . $uid;
            if (move_uploaded_file($file, $root . '/public/' . $relativePath)) {
                $image = new Image();
                $image->path = $relativePath;
                $image->created_at = date("Y-m-d H:i:s");
                $image->bulletin()->associate($bulletin);
                $image->save();
            }
        }
    }

    public function validate(array $files): bool
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        foreach ($files as $file) {
            $mime = finfo_file($finfo, $file);

            if (! in_array($mime, static::ALLOWED_MIME_TYPES)) {
                return false;
            }
        }

        return true;
    }
}