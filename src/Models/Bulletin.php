<?php

namespace Bodianskii\BulletinService\Models;

use Illuminate\Database\Eloquent\Model;

class Bulletin extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title', 'price', 'description', 'created_at'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
