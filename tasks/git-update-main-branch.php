<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use function Castor\context;
use function Castor\run;

function gitUpdateBranch(string $branch): void
{
    $context = context();

     run(
        command: [
            'git',
            'fetch',
        ],
        context: $context
    );

     run(
        command: [
            'git',
            'checkout',
            $branch,
        ],
        context: $context
    );

     run(
        command: [
            'git',
            'pull',
            'origin',
            $branch,
        ],
        context: $context
    );
}
