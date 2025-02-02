<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

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
    }, context: 'default_context');

    io()->comment('Code updated');
}
