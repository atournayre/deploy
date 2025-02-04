<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use Atournayre\Deploy\Rules\Git\GitTag;
use function Castor\context;

function gitTag(string $tag): void
{
    (new GitTag(context(), $tag))
        ->execute();
}
