<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use Atournayre\Deploy\Helper\ContextHelper;
use Atournayre\Deploy\Rules\Symfony\SymfonyCacheClear;
use function Castor\context;

function cacheClear(): void
{
    $context = ContextHelper::new()
        ->context();

    (new SymfonyCacheClear($context))
        ->execute();
}
