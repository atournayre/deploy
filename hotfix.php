<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Hotfix;

use Castor\Attribute\AsTask;
use function Atournayre\Deploy\Tasks\cacheClear;
use function Atournayre\Deploy\Tasks\confirmDeploy;
use function Atournayre\Deploy\Tasks\dotEnv;
use function Atournayre\Deploy\Tasks\postDeploy;
use function Atournayre\Deploy\Tasks\preDeploy;
use function Atournayre\Deploy\Tasks\updateCode;
use function Castor\import;
use function Castor\io;

#[AsTask(namespace: 'hotfix', description: 'Deploy Hotfix')]
function deploy(): void
{
    $dotEnv = dotEnv();

    io()->section('Deploy Hotfix');

    confirmDeploy();

    \Castor\run(
        command: [
            $dotEnv['CASTOR_BIN'],
            'hook:pre-deploy',
        ],
    );

    updateCode($dotEnv['MAIN_BRANCH']);

    \Castor\run(
        command: [
            $dotEnv['CASTOR_BIN'],
            'hook:post-update-code',
        ],
    );

    cacheClear();

    \Castor\run(
        command: [
            $dotEnv['CASTOR_BIN'],
            'hook:post-deploy',
        ],
    );
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

