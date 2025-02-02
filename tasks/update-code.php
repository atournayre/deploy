<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use Castor\Attribute\AsContext;
use Castor\Context;
use function Castor\io;
use function Castor\run;
use function Castor\with;

function updateCode(): void
{
    io()->title('Update the code');

    with(function (Context $context) {
        run('pwd');
        run(['git', 'fetch',]);
        run(['git', 'checkout', $context['MAIN_BRANCH'],]);
        run(['git', 'pull', 'origin', $context['MAIN_BRANCH'],]);
    }, context: 'git_context');

    io()->comment('Code updated');
}

#[AsContext(name: 'git_context')]
function create_git_context(): Context
{
    $dotEnv = dotEnv();

    return new Context(
        [
            'MAIN_BRANCH' => $dotEnv['MAIN_BRANCH'],
        ],
        workingDirectory: $dotEnv['APP_DIRECTORY']
    );
}
