<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Configuration;

final readonly class ConfigComposer
{
    public function __construct(
        public string $jsonPath,
    )
    {
    }
}