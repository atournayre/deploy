<?php
declare(strict_types=1);

namespace GroupeMasProvence\Deploy\Tasks;

use function Castor\io;

function updateCode(string $branch): void
{
    $dotEnv = dotEnv();

    io()->title('Update the code');

    \Castor\run(['cd', $dotEnv['APP_DIRECTORY'],]);
//    \Castor\run(['git', 'fetch',]);
//    \Castor\run(['git', 'checkout', $branch,]);
//    \Castor\run(['git', 'pull', 'origin', $branch,]);

    io()->comment('Code updated');
}
