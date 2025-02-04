<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Rules\Git;

use Castor\Context;
use function Castor\run;

final readonly class GitPush
{
    private function __construct(
        private Context $context,
        private string $remote,
        private string $branch,
    )
    {
    }

    public static function new(Context $context, string $remote, string $branch): self
    {
        return new self($context, $remote, $branch);
    }

    public function run(): void
    {
        run(
            command: [
                'git',
                'push',
                $this->remote,
                $this->branch,
            ],
            context: $this->context,
        );
    }
}