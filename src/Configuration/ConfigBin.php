<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Configuration;

final readonly class ConfigBin
{
    public function __construct(
        public string $php,
        public string $composer,
        public string $castor,
        public string $symfony,
    )
    {
    }
}