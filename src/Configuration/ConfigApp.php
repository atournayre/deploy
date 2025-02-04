<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Configuration;

final readonly class ConfigApp
{
    public function __construct(
        public string $env,
        public int $debug,
    )
    {
    }
}