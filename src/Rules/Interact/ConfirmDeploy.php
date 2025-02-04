<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Rules\Interact;

use Castor\Context;
use function Castor\io;

final readonly class ConfirmDeploy
{
   public function confirm(): void
    {
        $confirm = io()->ask('Are you sure you want to deploy ? [yes/no] : ');

        if ($confirm !== 'yes') {
            io()->writeln('<fg=red>Deployment cancelled</>');
            exit;
        }

        io()->writeln('<fg=green>Deployment confirmed</>');
    }
}
