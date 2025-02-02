<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use function Symfony\Component\String\u;

function incrementAppVersion(string $version): string
{
    $minor = u($version)
        ->beforeLast('.')
        ->toString()
    ;

    $patch = u($version)
        ->afterLast('.')
        ->toString()
    ;

    $newPatch = (int) $patch + 1;

    return u($minor)
        ->append('.', (string) $newPatch)
        ->toString()
    ;
}
