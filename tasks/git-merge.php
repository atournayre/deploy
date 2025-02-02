<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use function Castor\context;
use function Castor\run;

function gitMerge(string $branch): void
{
    $context = context();

    $process = run(
        command: [
            'git',
            'merge',
            '--no-ff',
            '-X',
            'theirs',
            $branch,
        ],
        context: $context->withQuiet(),
    );

    if ($process->getExitCode() !== 0) {
        throw new \RuntimeException('Merge failed.');
    }
}
