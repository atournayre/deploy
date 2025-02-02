<?php
declare(strict_types=1);

namespace GroupeMasProvence\Deploy;

use Castor\Attribute\AsTask;
use function Castor\io;

#[AsTask(namespace: 'patch')]
function generate(string $version): void
{
    io()->section('Generate patch');
}

#[AsTask(name: '23.1.1', namespace: 'patch', description: 'Patch 23.1.1',)]
function patch2311(): void
{
    io()->section('Patch 23.1.1');
}

