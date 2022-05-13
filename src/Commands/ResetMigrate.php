<?php

namespace Bodianskii\BulletinService\Commands;

use Bodianskii\BulletinService\Database\DatabaseManager;

class ResetMigrate implements CommandInterface
{
    public function execute(): void
    {
        foreach (array_reverse(DatabaseManager::$migrations) as $migration) {
            $migration::down();
            print_r("{$migration} dropped!\n");
        }
    }
}