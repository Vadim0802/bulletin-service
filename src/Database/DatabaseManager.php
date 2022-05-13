<?php

namespace Bodianskii\BulletinService\Database;

use Bodianskii\BulletinService\Database\Migrations\CreateBulletinsTable;
use Bodianskii\BulletinService\Database\Migrations\CreateImagesTable;
use Bodianskii\BulletinService\Database\Migrations\MigrateInterface;
use Illuminate\Database\Capsule\Manager as Capsule;

class DatabaseManager
{
    public static array $migrations = [
        CreateBulletinsTable::class,
        CreateImagesTable::class,
    ];

    public static function initial(): void
    {
        $capsule = new Capsule();
        $capsule->addConnection([
            "driver" => $_ENV["DB_DRIVER"] ?? 'pgsql',
            "host" => $_ENV['DB_HOST'] ?? 'localhost',
            "database" => $_ENV['DB_NAME'] ?? 'bulletin-service',
            "username" => $_ENV['DB_USER'] ?? 'postgres',
            "password" => $_ENV['DB_PASSWORD'] ?? 'postgres'
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}