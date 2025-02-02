<?php
declare(strict_types=1);

namespace GroupeMasProvence\Deploy\Tasks;

use function Castor\context;
use function Castor\io;

function cacheClear(): void
{
    $dotEnv = dotEnv();

    io()->title('Cache clear');

    \Castor\run(
        command: [
            $dotEnv['PHP_BIN'],
            $dotEnv['BIN_CONSOLE'],
            'cache:clear',
        ],
        context: context()->withEnvironment([
            'APP_ENV' => $dotEnv['APP_ENV'],
            'APP_DEBUG' => $dotEnv['APP_DEBUG'],
        ])
    );

    io()->comment('Cache cleared');
}
