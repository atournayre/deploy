<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use Atournayre\Deploy\Rules\Git\GitCommitAllChanges;
use function Castor\context;

function gitCommitAllChanges(string $message): void
{
    (new GitCommitAllChanges(context(), $message))
        ->execute();
}
