<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use function Castor\context;
use function Castor\run;

function gitList(string $branchPattern): array
{
    $context = context();

    $process = run(
        command: [
            'git',
            'branch',
            '--list',
            $branchPattern,
        ],
        context: $context->withQuiet(),
    );

    $branches = array_filter(
        explode("\n", trim($process->getOutput()))
    );

    return array_map(
        fn(string $branch) => trim(str_replace('* ', '', $branch)),
        $branches
    );
}
