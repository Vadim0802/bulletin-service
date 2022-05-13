<?php

namespace Bodianskii\BulletinService\Commands;

use Bodianskii\BulletinService\Database\DatabaseManager;

class Migrate implements CommandInterface
{
    public function execute(): void
    {
        foreach (DatabaseManager::$migrations as $migration) {
            $migration::up();
            print_r("{$migration} completed!\n");
        }
    }
}