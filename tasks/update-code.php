<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use Castor\Attribute\AsContext;
use Castor\Context;
use function Castor\io;
use function Castor\with;

function updateCode(): void
{
    io()->title('Update the code');

    with(function (Context $context) {
        \Castor\run('pwd');
        \Castor\run(['git', 'fetch',]);
        \Castor\run(['git', 'checkout', $context['main_branch'],]);
        \Castor\run(['git', 'pull', 'origin', $context['main_branch'],]);
    }, context: 'git_context');

    io()->comment('Code updated');
}

#[AsContext(name: 'git_context')]
function create_git_context(): Context
{
    $dotEnv = dotEnv();

    return new Context(
        [
            'main_branch' => $dotEnv['MAIN_BRANCH'],
        ],
        workingDirectory: $dotEnv['APP_DIRECTORY']
    );
}
