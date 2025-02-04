<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Tasks;

use Atournayre\Deploy\Rules\Git\GitCheckUncommitedFiles;
use function Castor\context;

function checkUncommitedFiles(string $message): void
{
    $context = context();
    (new GitCheckUncommitedFiles($context, $message))
        ->execute();
}
