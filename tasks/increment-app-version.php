<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use Atournayre\Deploy\Helper\VersionHelper;

function incrementAppVersion(string $version): string
{
    return (new VersionHelper($version))
        ->nextPatch()
    ;
}
