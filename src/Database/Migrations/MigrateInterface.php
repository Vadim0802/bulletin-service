<?php

namespace Bodianskii\BulletinService\Database\Migrations;

interface MigrateInterface
{
    public static function up(): void;
    public static function down(): void;
}