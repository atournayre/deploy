<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use function Castor\context;
use function Castor\run;

function gitPush(string $branch, string $remote = 'origin'): void
{
    $context = context();

    run(
        command: [
            'git',
            'push',
            $remote,
            $branch,
        ],
        context: $context,
    );
}
