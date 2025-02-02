<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use function Castor\context;
use function Castor\run;

function gitGetLastBranch(string $branchPattern): string
{
    $context = context();

    $process = run(
        command: [
            'git',
            'branch',
            '--list',
            $branchPattern,
            '--sort=-committerdate',
        ],
        context: $context->withQuiet(),
    );

    $branches = array_filter(
        explode("\n", trim($process->getOutput()))
    );

    $lastBranch = !empty($branches)
        ? trim(str_replace('* ', '', $branches[0]))
        : null;

    if (null === $lastBranch) {
        throw new \RuntimeException('Unable to get last '.$branchPattern.' branch.');
    }

    return $lastBranch;
}
