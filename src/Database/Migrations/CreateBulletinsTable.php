<?php

namespace Bodianskii\BulletinService\Database\Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class CreateBulletinsTable implements MigrateInterface
{
    public static function up(): void
    {
        if (! Capsule::schema()->hasTable('bulletins')) {
            Capsule::schema()->create('bulletins', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->integer('price');
                $table->string('description');
                $table->timestamp('created_at');
            });
        }
    }

    public static function down(): void
    {
        if (Capsule::schema()->hasTable('bulletins')) {
            Capsule::schema()->drop('bulletins');
        }
    }
}