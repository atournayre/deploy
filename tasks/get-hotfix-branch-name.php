<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use Atournayre\Deploy\Helper\ApplicationHelper;
use function Castor\context;

function getHotfixBranchName(string $version): string
{
    return (new ApplicationHelper(context()))
        ->hotfixBranchName($version)
    ;
}
