<?php

namespace Bodianskii\BulletinService\Commands;

use Exception;
use InvalidArgumentException;

class CommandHandler
{
    private array $commands = [
        '-migrate' => Migrate::class,
        '-reset' => ResetMigrate::class
    ];

    public function handle(?string $command)
    {
        if (array_key_exists($command, $this->commands)) {
            $commandInstance = new $this->commands[$command]();
            $commandInstance->execute();
        }
    }
}