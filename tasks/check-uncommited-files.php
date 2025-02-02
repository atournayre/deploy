<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use RuntimeException;
use function Castor\context;
use function Castor\run;

function checkUncommitedFiles(string $message): void
{
    $context = context();

    $process = run(
        command: [
            'git',
            'status',
            '--porcelain',
        ],
        context: $context
    );

    if (!empty($process->getOutput())) {
        throw new RuntimeException($message ?: 'There are uncommitted changes in your working directory.');
    }
}
