<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Release;

use Castor\Attribute\AsTask;
use function Atournayre\Deploy\Tasks\gitCreateBranch;
use function Atournayre\Deploy\Tasks\getAppVersion;
use function Atournayre\Deploy\Tasks\gitCommitAllChanges;
use function Atournayre\Deploy\Tasks\gitPush;
use function Atournayre\Deploy\Tasks\hook;
use function Atournayre\Deploy\Tasks\updateAppVersion;
use function Atournayre\Deploy\Tasks\gitUpdateBranch;
use function Castor\context;
use function Castor\io;

#[AsTask(namespace: 'release', description: 'Create release branch')]
function create(): void
{
    io()->section('Create release branch');

    $context = context();
    $appVersion = getAppVersion();
    $releaseNumber = releaseNumber($appVersion);

    $defaultReleaseNumber = 'release/'.$releaseNumber;
    $releaseBranch = io()
        ->ask('What is the name of the release branch ? [release/'.$releaseNumber.'] : ', $defaultReleaseNumber);

    gitUpdateBranch($context['DEVELOP_BRANCH']);
    gitCreateBranch($releaseBranch, $context['DEVELOP_BRANCH']);
    gitPush($releaseBranch);

    updateAppVersion($releaseNumber);
    hook('hook:hotfix-post-update-version');
    gitCommitAllChanges('Version '.$releaseNumber);
    gitPush($releaseBranch);

    io()->success('Release branch created');
}
