<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use function Castor\context;
use function Castor\run;

function gitCommitAllChanges(string $message): void
{
    $context = context();

    run(
        command: [
            'git',
            'add',
            '.',
        ],
        context: $context,
    );

    run(
        command: [
            'git',
            'commit',
            '-m',
            $message,
        ],
        context: $context,
    );
}
