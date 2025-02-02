<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use function Castor\context;
use function Castor\run;

function gitUpdateMainBranch(): void
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
            $context['MAIN_BRANCH'],
        ],
        context: $context
    );

     run(
        command: [
            'git',
            'pull',
            'origin',
            $context['MAIN_BRANCH'],
        ],
        context: $context
    );
}
