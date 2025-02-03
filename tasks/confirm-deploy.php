<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use Atournayre\Deploy\Rules\Interact\ConfirmDeploy;

function confirmDeploy(): void
{
    (new ConfirmDeploy())
        ->execute();
}
