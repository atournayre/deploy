<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Rules\Git;

use Castor\Context;
use function Castor\run;

final readonly class GitUpdate
{
    private function __construct(
        private Context $context,
        private string $origin,
        private string $branch,
    )
    {
    }

    public static function new(Context $context, string $origin, string $branch): self
    {
        return new self($context, $origin, $branch);
    }

    public function run(): void
    {
        run(
            command: [
                'git',
                'fetch',
            ],
            context: $this->context,
        );

        run(
            command: [
                'git',
                'checkout',
                $this->branch,
            ],
            context: $this->context,
        );

        run(
            command: [
                'git',
                'pull',
                $this->origin,
                $this->branch,
            ],
            context: $this->context,
        );
    }
}