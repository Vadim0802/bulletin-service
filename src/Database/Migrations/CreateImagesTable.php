<?php

namespace Bodianskii\BulletinService\Database\Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class CreateImagesTable implements MigrateInterface
{
    public static function up(): void
    {
        if (! Capsule::schema()->hasTable('images')) {
            Capsule::schema()->create('images', function (Blueprint $table) {
                $table->id();
                $table->string('path');
                $table->timestamp('created_at');
                $table->foreignId('bulletin_id')->constrained()->cascadeOnDelete();
            });
        }
    }

    public static function down(): void
    {
        if (Capsule::schema()->hasTable('images')) {
            Capsule::schema()->drop('images');
        }
    }
}