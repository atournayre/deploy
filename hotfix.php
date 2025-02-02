<?php
declare(strict_types=1);

namespace GroupeMasProvence\Deploy\Hotfix;

use Castor\Attribute\AsTask;
use function GroupeMasProvence\Deploy\Tasks\cacheClear;
use function GroupeMasProvence\Deploy\Tasks\confirmDeploy;
use function GroupeMasProvence\Deploy\Tasks\dotEnv;
use function GroupeMasProvence\Deploy\Tasks\postDeploy;
use function GroupeMasProvence\Deploy\Tasks\preDeploy;
use function GroupeMasProvence\Deploy\Tasks\updateCode;
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

    // Install front dependencies

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

