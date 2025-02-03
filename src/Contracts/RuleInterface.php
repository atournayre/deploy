<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Contracts;

interface RuleInterface
{
    public function execute(): void;
}
