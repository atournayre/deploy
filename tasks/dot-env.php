<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use function Castor\io;
use function Castor\load_dot_env;

function dotEnv(): array
{
    $path = getcwd() . '/tools/castor/.env';

    io()->note('Using .env file : ' . $path);

    return load_dot_env($path);
}
