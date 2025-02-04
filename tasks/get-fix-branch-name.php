<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use Atournayre\Deploy\Helper\ApplicationHelper;
use function Castor\context;

function getFixBranchName(string $hotfixBranchName, string $issueNumber): string
{
    return (new ApplicationHelper(context()))
        ->fixBranchName($hotfixBranchName, $issueNumber)
    ;
}
