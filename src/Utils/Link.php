<?php

namespace Bodianskii\BulletinService\Utils;

class Link
{
    public static function build($path): string
    {
        $domain = $_SERVER['SERVER_NAME'];
        $protocol = strtolower(explode('/', $_SERVER['SERVER_PROTOCOL'])[0]);

        return "{$protocol}://{$domain}/{$path}";
    }
}
