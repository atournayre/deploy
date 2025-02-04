<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Rules\Git;

use Castor\Context;
use function Castor\run;

final readonly class GitCommitAllChanges
{
    private function __construct(
        private Context $context,
        private string $message,
    )
    {
    }

    public static function new(Context $context, string $message): self
    {
        return new self($context, $message);
    }

    public function run(): void
    {
        run(
            command: [
                'git',
                'add',
                '.',
            ],
            context: $this->context,
        );

        run(
            command: [
                'git',
                'commit',
                '-m',
                $this->message,
            ],
            context: $this->context,
        );
    }
}
