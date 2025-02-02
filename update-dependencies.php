<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Hotfix;

use Castor\Attribute\AsTask;
use function Atournayre\Deploy\Tasks\checkUncommitedFiles;
use function Atournayre\Deploy\Tasks\composerUpdate;
use function Atournayre\Deploy\Tasks\gitCommitAllChanges;
use function Atournayre\Deploy\Tasks\gitCreateBranch;
use function Atournayre\Deploy\Tasks\gitPush;
use function Atournayre\Deploy\Tasks\gitUpdateBranch;
use function Atournayre\Deploy\Tasks\hook;
use function Castor\context;
use function Castor\io;

#[AsTask(namespace: 'dependencies', description: 'Update dependencies')]
function update(): void
{
    io()->section('Update dependencies');

    checkUncommitedFiles('Unable to update dependencies because there are uncommitted changes in your working directory.');

    $context = context();
    $branch = $context['DEVELOP_BRANCH'];
    gitUpdateBranch($branch);

    composerUpdate(['--dry-run']);

    $confirm = io()->ask('Do you want to update dependencies ? [y/n]');

    if ($confirm !== 'y') {
        io()->writeln('<fg=red>Update cancelled</>');
        return;
    }

    $currentDate = date('Y-m-d');
    $branchName = 'update-deps/'.$currentDate;

    gitCreateBranch($branchName, $context['MAIN_BRANCH']);

    composerUpdate();

    hook('hook:composer-post-update');

    gitCommitAllChanges('Update dependencies '.$currentDate);
    gitPush($branchName);

    io()->success('Update dependencies done');

    io()->comment('Next: submit a PR to merge the branch '.$branchName.' into '.$branchName);
}
