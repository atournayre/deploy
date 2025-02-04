<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use Atournayre\Deploy\Rules\Git\GitPush;
use function Castor\context;

function gitPush(string $branch, string $remote = 'origin'): void
{
    (new GitPush(context(), $remote, $branch))
        ->execute();
}
