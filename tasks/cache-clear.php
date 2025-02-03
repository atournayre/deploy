<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use Atournayre\Deploy\Rules\Symfony\CacheClear;
use function Castor\context;

function cacheClear(): void
{
    $dotEnv = dotEnv();

    $context = context()->withEnvironment([
        'APP_ENV' => $dotEnv['APP_ENV'],
        'APP_DEBUG' => $dotEnv['APP_DEBUG'],
    ]);

    (new CacheClear($context))
        ->execute();
}
