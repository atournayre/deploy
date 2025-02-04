<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Rules\Git;

use Castor\Context;
use function Castor\run;

final readonly class GitLastBranch
{
    private function __construct(
        private Context $context,
        private string $branch,
        private string $startPoint,
    )
    {
    }

    public static function new(Context $context, string $branch, string $startPoint): self
    {
        return new self($context, $branch, $startPoint);
    }

    public function run(): void
    {
        run(
            command: array_filter([
                'git',
                'checkout',
                '-b',
                $this->branch,
                $this->startPoint,
            ]),
          context: $this->context,
        );
    }
}