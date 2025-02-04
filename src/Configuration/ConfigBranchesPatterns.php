<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Configuration;

final readonly class ConfigBranchesPatterns
{
    public function __construct(
        public string $release,
        public string $hotfix,
        public string $fix,
        public string $updateDependencies,
    )
    {
    }
}