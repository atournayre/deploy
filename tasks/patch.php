<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use Atournayre\Deploy\Helper\ContextHelper;
use Atournayre\Deploy\Rules\Patch\PatchApply;
use function Castor\context;

function patch(): void
{
    $context = ContextHelper::new()->context();

    (new PatchApply($context))
        ->execute();
}
