<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Helper;

use function Symfony\Component\String\u;

final readonly class VersionHelper
{
    public function __construct(
        private string $version,
    )
    {
    }

    public function nextPatch(): string
    {
        $minor = u($this->version)
            ->beforeLast('.')
            ->toString()
        ;

        $patch = u($this->version)
            ->afterLast('.')
            ->toString()
        ;

        $newPatch = (int) $patch + 1;

        return u($minor)
            ->append('.', (string) $newPatch)
            ->toString()
        ;
    }
}