<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use Castor\Attribute\AsTask;
use function Castor\run;


function hook(string $hook): void
{
    $dotEnv = dotEnv();

    run(
        command: [
            $dotEnv['CASTOR_BIN'],
            $hook,
        ],
    );
}

#[AsTask(namespace: 'hook', description: 'Pre-deploy hook')]
function preDeploy(): void {}

#[AsTask(namespace: 'hook', description: 'Post-deploy hook')]
function postDeploy(): void {}

#[AsTask(namespace: 'hook', description: 'Post update code hook')]
function postUpdateCode(): void {}
