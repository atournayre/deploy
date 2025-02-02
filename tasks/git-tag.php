<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use function Castor\context;
use function Castor\run;

function gitTag(string $tag): void
{
    $context = context();

    run(
        command: [
            'git',
            'tag',
            $tag,
        ],
        context: $context,
    );

    run(
        command: [
            'git',
            'push',
            '--tags',
        ],
        context: $context,
    );
}
