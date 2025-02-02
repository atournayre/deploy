<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use function Castor\context;
use function Castor\fs;
use function Castor\io;
use function Castor\run;
use function Symfony\Component\String\u;

function patch(): void
{
    $context = context();
    $appVersion = getAppVersion();

    $patch = u($context['PATCH_DIRECTORY'])
        ->append('/', $appVersion, '.php')
        ->toString()
    ;

    if (!fs()->exists($patch)) {
        io()->note('No patch to apply for version '.$appVersion);
        return;
    }

    io()->title('Apply patch '.$appVersion);

    run(
        command: [
            $context['PHP_BIN'],
            $context['BIN_CONSOLE'],
            'patch:'.$patch,
        ],
        context: $context,
    );
}
