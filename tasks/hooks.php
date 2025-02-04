<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use Atournayre\Deploy\Helper\ContextHelper;
use Castor\Attribute\AsTask;
use function Castor\run;


function hook(string $hook): void
{
    $context = ContextHelper::new()
        ->context();

    run(
        command: [
            $context['CASTOR_BIN'],
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

#[AsTask(namespace: 'hook', description: 'Hotfix post update version hook')]
function hotfixPostUpdateVersion(): void {}

#[AsTask(namespace: 'hook', description: 'Composer post update hook')]
function composerPostUpdate(): void {}
