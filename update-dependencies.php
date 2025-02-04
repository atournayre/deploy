<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Hotfix;

use Atournayre\Deploy\Configuration\Config;
use Atournayre\Deploy\Rules\Composer\ComposerUpdate;
use Atournayre\Deploy\Rules\Git\GitCheckUncommitedFiles;
use Atournayre\Deploy\Rules\Git\GitCommitAllChanges;
use Atournayre\Deploy\Rules\Git\GitCreateBranch;
use Atournayre\Deploy\Rules\Git\GitPush;
use Atournayre\Deploy\Rules\Git\GitUpdate;
use Atournayre\Deploy\Rules\Hook\Hook;
use Castor\Attribute\AsTask;
use function Castor\context;
use function Castor\io;

#[AsTask(namespace: 'dependencies', description: 'Update dependencies')]
function update(): void
{
    $config = Config::new();
    $context = context();

    io()->section('Update dependencies');

    GitCheckUncommitedFiles::new($context, 'Unable to update dependencies because there are uncommitted changes in your working directory.')
        ->run();

    GitUpdate::new(
        $context,
        $config->branches->origin,
        $config->branches->develop,
    )->run();

    ComposerUpdate::new($context)
        ->dryRun();

    $confirm = io()->ask('Do you want to update dependencies ? [y/n]');

    if ($confirm !== 'y') {
        io()->writeln('<fg=red>Update cancelled</>');
        return;
    }

    $currentDate = new \DateTime();
    $branchName = $config->branches->patterns->updateDependencies.'/'.$currentDate->format('Y-m-d');

    GitCreateBranch::new(
        $context,
        $branchName,
        $config->branches->origin,
    )->run();

    ComposerUpdate::new($context)
        ->run();

    Hook::new($context, $config, 'hook:composer-post-update')
        ->apply();

    GitCommitAllChanges::new(
        $context,
        'Update dependencies '.$currentDate->format('Y-m-d'),
    )->run();

    GitPush::new(
        $context,
        $config->branches->origin,
        $branchName,
    )->run();

    io()->success('Update dependencies done');

    io()->comment('Next: submit a PR to merge the branch '.$branchName.' into '.$branchName);
}
