<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Rules\Git;

use Castor\Context;
use function Castor\run;

final readonly class GitTag
{
    private function __construct(
        private Context $context,
        private string $tag,
    )
    {
    }

    public static function new(Context $context, string $tag): self
    {
        return new self($context, $tag);
    }

    public function run(): void
    {
        run(
            command: [
                'git',
                'tag',
                $this->tag,
            ],
            context: $this->context,
        );

        run(
            command: [
                'git',
                'push',
                '--tags',
            ],
            context: $this->context,
        );
    }
}