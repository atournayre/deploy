<?php
declare(strict_types=1);

namespace Atournayre\Deploy;

use Castor\Attribute\AsTask;
use function Castor\io;

#[AsTask(namespace: 'deploy', description: 'Deploy the application',)]
function env(string $env): void
{
}


// TODO Command to install Castor and create the castor.php file which will contain the imports

