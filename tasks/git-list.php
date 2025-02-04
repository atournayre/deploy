<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use Atournayre\Deploy\Helper\GitHelper;
use function Castor\context;

function gitList(string $branchPattern): array
{
    return (new GitHelper(context()))
        ->listBranches($branchPattern)
    ;
}
