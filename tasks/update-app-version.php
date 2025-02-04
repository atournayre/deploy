<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use Atournayre\Deploy\Rules\Application\ApplicationUpdateVersion;
use function Castor\context;

function updateAppVersion(string $version): void
{
    (new ApplicationUpdateVersion(context(), $version))
        ->execute();
}
