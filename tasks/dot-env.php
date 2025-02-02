<?php
declare(strict_types=1);

namespace GroupeMasProvence\Deploy\Tasks;

use function Castor\load_dot_env;

function dotEnv(): array
{
    return load_dot_env(getcwd().'/tools/castor/.env');
}
