<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use Castor\Attribute\AsTask;
use function Castor\io;


function hook(string $hook): void
{
    $dotEnv = dotEnv();

    \Castor\run(
        command: [
            $dotEnv['CASTOR_BIN'],
            $hook,
        ],
    );
}

#[AsTask(namespace: 'hook', description: 'Pre-deploy hook')]
function preDeploy(): void
{
    io()->title('Pre-deploy');
}

#[AsTask(namespace: 'hook', description: 'Post-deploy hook')]
function postDeploy(): void
{
    io()->title('Post-deploy');
}
#[AsTask(namespace: 'hook', description: 'Post update code hook')]
function postUpdateCode(): void
{
    io()->title('Post update code');
}
