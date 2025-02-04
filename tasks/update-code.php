<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use Atournayre\Deploy\Helper\ContextHelper;
use Atournayre\Deploy\Rules\Git\GitUpdate;

function updateCode(): void
{
    $context = ContextHelper::new()
        ->context();

    (new GitUpdate($context, $context['MAIN_BRANCH']))
        ->execute();
}
