<?php
declare(strict_types=1);

namespace GroupeMasProvence\Deploy\Tasks;

use Castor\Attribute\AsTask;
use function Castor\io;

#[AsTask(namespace: 'hook', description: 'Pre-deploy hook')]
function preDeploy(): void
{
    io()->title('Pre-deploy');
}

#[AsTask(namespace: 'hook', description: 'Pre-deploy hook')]
function postDeploy(): void
{
    io()->title('Post-deploy');
}
