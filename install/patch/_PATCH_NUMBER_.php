<?php
declare(strict_types=1);

namespace App\Tools\Castor\Patch;

use Castor\Attribute\AsTask;
use function Castor\io;

#[AsTask(name: '_PATCH_NUMBER_', namespace: 'patch', description: 'Patch _PATCH_NUMBER_')]
function patch_PATCH_NAME_(): void
{
    io()->section('Patch _PATCH_NUMBER_');

    // TODO patch
}
