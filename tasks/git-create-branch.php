<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use Atournayre\Deploy\Rules\Git\GitCreateBranch;
use function Castor\context;

function gitCreateBranch(string $branch, ?string $startPoint = null): void
{
    (new GitCreateBranch(context(), $branch, $startPoint))
        ->execute();
}
