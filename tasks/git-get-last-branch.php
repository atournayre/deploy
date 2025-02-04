<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use Atournayre\Deploy\Helper\GitHelper;
use function Castor\context;

function gitGetLastBranch(string $branchPattern): string
{
    return (new GitHelper(context()))
        ->lastBranch($branchPattern)
    ;
}
