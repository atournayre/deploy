<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Hotfix;

use Castor\Attribute\AsTask;
use function Atournayre\Deploy\Tasks\cacheClear;
use function Atournayre\Deploy\Tasks\checkUncommitedFiles;
use function Atournayre\Deploy\Tasks\confirmDeploy;
use function Atournayre\Deploy\Tasks\getFixBranchName;
use function Atournayre\Deploy\Tasks\gitCreateBranch;
use function Atournayre\Deploy\Tasks\getAppVersion;
use function Atournayre\Deploy\Tasks\getHotfixBranchName;
use function Atournayre\Deploy\Tasks\gitCommitAllChanges;
use function Atournayre\Deploy\Tasks\gitPush;
use function Atournayre\Deploy\Tasks\hook;
use function Atournayre\Deploy\Tasks\incrementAppVersion;
use function Atournayre\Deploy\Tasks\updateAppVersion;
use function Atournayre\Deploy\Tasks\updateCode;
use function Atournayre\Deploy\Tasks\gitUpdateMainBranch;
use function Castor\io;

#[AsTask(namespace: 'hotfix', description: 'Deploy Hotfix')]
function deploy(): void
{
    io()->section('Deploy Hotfix');

    confirmDeploy();
    hook('hook:pre-deploy');
    updateCode();
    hook('hook:post-update-code');
    cacheClear();
    hook('hook:post-deploy');

    io()->success('Hotfix deployed');
}

#[AsTask(namespace: 'hotfix', description: 'Generate hotfix branch')]
function generate(): void
{
    io()->section('Generate hotfix');
    checkUncommitedFiles('Unable to create hotfix because there are uncommitted changes in your working directory.');
    gitUpdateMainBranch();

    $appVersion = getAppVersion();
    $newVersion = incrementAppVersion($appVersion);
    $hotfixBranchName = getHotfixBranchName($newVersion);

    gitCreateBranch($hotfixBranchName);
    updateAppVersion($newVersion);
    hook('hook:hotfix-post-update-version');
    gitCommitAllChanges('Version '.$newVersion);
    gitPush($hotfixBranchName);

    $issueNumber = io()
        ->ask('Do you want to create a branch for a specific issue in the hotfix branch ? Type issue number or leave empty to skip this step.');

    if ($issueNumber) {
        $issueBranchName = getFixBranchName($hotfixBranchName, $issueNumber);
        gitCreateBranch($issueBranchName, $hotfixBranchName);
    }

    io()->success('Hotfix generated');
}

#[AsTask(namespace: 'hotfix', description: 'Merge hotfix into main, develop and releases')]
function merge(): void
{
    io()->section('Merge hotfix');
}

