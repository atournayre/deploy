<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Rules\Interact;

use function Castor\io;

final readonly class ReleaseNumber
{
    private function __construct(
        private string $version,
    )
    {
    }

    public static function new(string $version): self
    {
        return new self($version);
    }

    public function ask(): string
    {
        $parts = array_map('intval', explode('.', $this->version));
        [$major, $minor, $patch] = $parts;

        if (io()->ask('Fix bug ? [y/n] : ') === 'y') {
            return "{$major}.{$minor}." . ($patch + 1);
        }

        if (io()->ask('Add feature ? [y/n] : ') === 'y') {
            return "{$major}." . ($minor + 1) . ".0";
        }

        return ($major + 1) . ".0.0";
    }
}