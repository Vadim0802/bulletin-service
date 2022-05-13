<?php

namespace Bodianskii\BulletinService\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public $timestamps = false;

    protected $fillable = ['path'];
    protected $guarded = ['bulletin_id'];

    protected $casts = ['created_at' => 'datetime'];

    public function bulletin()
    {
        return $this->belongsTo(Bulletin::class);
    }
}