<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Release;

use Castor\Attribute\AsTask;
use Symfony\Component\Console\Question\ChoiceQuestion;
use function Atournayre\Deploy\Tasks\checkUncommitedFiles;
use function Atournayre\Deploy\Tasks\gitCreateBranch;
use function Atournayre\Deploy\Tasks\getAppVersion;
use function Atournayre\Deploy\Tasks\gitCommitAllChanges;
use function Atournayre\Deploy\Tasks\gitList;
use function Atournayre\Deploy\Tasks\gitMerge;
use function Atournayre\Deploy\Tasks\gitPush;
use function Atournayre\Deploy\Tasks\gitTag;
use function Atournayre\Deploy\Tasks\hook;
use function Atournayre\Deploy\Tasks\updateAppVersion;
use function Atournayre\Deploy\Tasks\gitUpdateBranch;
use function Castor\context;
use function Castor\io;
use function Symfony\Component\String\u;

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

#[AsTask(namespace: 'release', description: 'Merge release into main')]
function merge(): void
{
    io()->section('Merge release');

    $context = context();

    checkUncommitedFiles('Unable to merge release because there are uncommitted changes in your working directory.');

    $releases = gitList('release/*');

    $question = new ChoiceQuestion('Choose a release to merge : ', $releases);
    $release = io()->askQuestion($question);

    gitUpdateBranch($release);
    gitUpdateBranch($context['MAIN_BRANCH']);

    gitMerge('origin/'.$release);
    gitPush('origin', $context['MAIN_BRANCH']);

    $tag = u($release)
        ->afterLast('/')
        ->toString()
    ;
    gitTag($tag);

    io()->success('Merge and push successful');
}

