<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Release;

use function Castor\io;

function releaseNumber(string $version): string
{
    $parts = array_map('intval', explode('.', $version));
    [$major, $minor, $patch] = $parts;

    if (io()->ask('Fix bug ? [y/n] : ') === 'y') {
        return "{$major}.{$minor}." . ($patch + 1);
    }

    if (io()->ask('Add feature ? [y/n] : ') === 'y') {
        return "{$major}." . ($minor + 1) . ".0";
    }

    return ($major + 1) . ".0.0";
}
