<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use function Castor\context;
use function Castor\run;

function composerUpdate(array $options = []): void
{
    run(
        command: array_merge([
            'composer',
            'update',
        ], $options),
        context: context(),
    );
}
