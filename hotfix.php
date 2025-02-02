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
use function Atournayre\Deploy\Tasks\gitGetLastBranch;
use function Atournayre\Deploy\Tasks\gitMerge;
use function Atournayre\Deploy\Tasks\gitPush;
use function Atournayre\Deploy\Tasks\hook;
use function Atournayre\Deploy\Tasks\incrementAppVersion;
use function Atournayre\Deploy\Tasks\patch;
use function Atournayre\Deploy\Tasks\updateAppVersion;
use function Atournayre\Deploy\Tasks\updateCode;
use function Atournayre\Deploy\Tasks\gitUpdateBranch;
use function Castor\context;
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
    patch();

    io()->success('Hotfix deployed');
}

#[AsTask(namespace: 'hotfix', description: 'Generate hotfix branch')]
function generate(): void
{
    io()->section('Generate hotfix');

    $context = context();

    checkUncommitedFiles('Unable to create hotfix because there are uncommitted changes in your working directory.');
    gitUpdateBranch($context['MAIN_BRANCH']);

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

    $context = context();

    checkUncommitedFiles('Unable to merge hotfix because there are uncommitted changes in your working directory.');
    gitUpdateBranch($context['MAIN_BRANCH']);

    $hotfixBranchName = gitGetLastBranch('hotfix/*');

    $useLastHotfix = io()
        ->ask('Use '.$hotfixBranchName.' for the hotfix ? [y/n] : ');

    if ($useLastHotfix !== 'y') {
        $hotfixBranchName = io()
            ->ask('What is the name of the hotfix branch ? [hotfix/x.y.z] : ');

    }
    gitUpdateBranch($hotfixBranchName);

    // TODO Replace by all the release branches greater than the current in main
    $releaseBranchName = gitGetLastBranch('release/*');

    $useLastRelease = io()
        ->ask('Use '.$releaseBranchName.' for the release ? [y/n] : ');

    if ($useLastRelease !== 'y') {
        gitUpdateBranch($releaseBranchName);

        try {
            io()->title('Merge hotfix into release');
            gitMerge($hotfixBranchName);
            gitPush($releaseBranchName);
            io()->success('Merge and push successful');
        } catch (\RuntimeException $e) {
            io()->warning('Merge failed, push cancelled. Please resolve conflicts manually.');
            io()->error($e->getMessage());
            return;
        }
    }

    try {
        $developBranchName = $context['DEVELOP_BRANCH'];
        io()->title('Merge hotfix into ' . $developBranchName);
        gitUpdateBranch($developBranchName);
        gitMerge($hotfixBranchName);
        gitPush($developBranchName);
        io()->success('Merge and push successful');
    } catch (\RuntimeException $e) {
        io()->warning('Merge failed, push cancelled. Please resolve conflicts manually.');
        io()->error($e->getMessage());
        return;
    }

    try {
        $mainBranchName = $context['MAIN_BRANCH'];
        io()->title('Merge hotfix into ' . $mainBranchName);
        gitUpdateBranch($mainBranchName);
        gitMerge($hotfixBranchName);
        gitPush($mainBranchName);
        io()->success('Merge and push successful');
    } catch (\RuntimeException $e) {
        io()->warning('Merge failed, push cancelled. Please resolve conflicts manually.');
        io()->error($e->getMessage());
        return;
    }

    io()->success('Hotfix merged');
}

