<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use Atournayre\Deploy\Rules\Git\GitMerge;
use function Castor\context;

function gitMerge(string $branch): void
{
    (new GitMerge(context(), $branch))
        ->execute();
}
