<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Configuration;

final readonly class ConfigBranches
{
    public function __construct(
        public string $origin,
        public string $develop,
        public string $main,
        public ConfigBranchesPatterns $patterns,
    )
    {
    }
}