<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Hotfix;

use Castor\Attribute\AsTask;
use function Atournayre\Deploy\Tasks\cacheClear;
use function Atournayre\Deploy\Tasks\confirmDeploy;
use function Atournayre\Deploy\Tasks\dotEnv;
use function Atournayre\Deploy\Tasks\hook;
use function Atournayre\Deploy\Tasks\updateCode;
use function Castor\io;

#[AsTask(namespace: 'hotfix', description: 'Deploy Hotfix')]
function deploy(): void
{
    $dotEnv = dotEnv();

    io()->section('Deploy Hotfix');

    confirmDeploy();
    hook('hook:pre-deploy');
    updateCode($dotEnv['MAIN_BRANCH']);
    hook('hook:post-update-code');
    cacheClear();
    hook('hook:post-deploy');

    io()->success('Hotfix deployed');
}

#[AsTask(namespace: 'hotfix', description: 'Generate hotfix branch')]
function generate(): void
{
    io()->section('Generate hotfix');
}

#[AsTask(namespace: 'hotfix', description: 'Merge hotfix into main, develop and releases')]
function merge(): void
{
    io()->section('Merge hotfix');
}

