<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use function Symfony\Component\String\u;

function getFixBranchName(string $hotfixBranchName, string $issueNumber): string
{
    return u($hotfixBranchName)
        ->replace('hotfix/', 'fix/')
        ->append('-', $issueNumber)
        ->toString()
    ;
}
