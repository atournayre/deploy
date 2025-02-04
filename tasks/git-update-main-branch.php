<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use Atournayre\Deploy\Rules\Git\GitUpdateBranch;
use function Castor\context;
use function Castor\run;

function gitUpdateBranch(string $branch): void
{
    (new GitUpdateBranch(context(), $branch))
        ->execute();
}
