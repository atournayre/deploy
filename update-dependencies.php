<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Hotfix;

use Castor\Attribute\AsTask;
use function Atournayre\Deploy\Tasks\checkUncommitedFiles;
use function Atournayre\Deploy\Tasks\gitUpdateBranch;
use function Castor\context;
use function Castor\io;
use function Castor\run;

#[AsTask(namespace: 'dependencies', description: 'Update dependencies', aliases: ['update-deps'])]
function update(): void
{
    io()->section('Update dependencies');

    checkUncommitedFiles('Unable to update dependencies because there are uncommitted changes in your working directory.');

    $context = context();
    gitUpdateBranch($context['DEVELOP_BRANCH']);

    run(
        command: [
            'composer',
            'update',
            '--dry-run',
        ],
        context: $context,
    );
}
