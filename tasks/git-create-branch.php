<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use function Castor\context;
use function Castor\run;

function gitCreateBranch(string $branch, ?string $startPoint = null): void
{
    run(
        command: array_filter([
            'git',
            'checkout',
            '-b',
            $branch,
            $startPoint,
        ]),
        context: context(),
    );
}
