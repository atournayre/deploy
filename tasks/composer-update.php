<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use Atournayre\Deploy\Rules\Composer\ComposerUpdate;
use function Castor\context;
use function Castor\run;

function composerUpdate(array $options = []): void
{
    (new ComposerUpdate(context(), $options))
        ->execute();
}
