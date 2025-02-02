<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

function getHotfixBranchName(string $version): string
{
    return 'hotfix/'.$version;
}
