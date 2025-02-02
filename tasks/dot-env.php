<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use Castor\Attribute\AsContext;
use Castor\Context;
use function Castor\io;
use function Castor\load_dot_env;

function dotEnv(): array
{
    $path = getcwd() . '/tools/castor/.env';

    io()->note('Using .env file : ' . $path);

    return load_dot_env($path);
}

#[AsContext(name: 'default_context', default: true)]
function create_default_context(): Context
{
    $dotEnv = dotEnv();

    return new Context(
        data:$dotEnv,
        workingDirectory: $dotEnv['APP_DIRECTORY']
    );
}