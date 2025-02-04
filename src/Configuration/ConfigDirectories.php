<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Configuration;

final readonly class ConfigDirectories
{
    public function __construct(
        public string $application,
        public string $patch,
    )
    {
    }
}