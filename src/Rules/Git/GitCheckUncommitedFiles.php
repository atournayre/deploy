<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Rules\Git;

use Castor\Context;
use function Castor\run;

final readonly class GitCheckUncommitedFiles
{
    private function __construct(
        private Context $context,
        private ?string $message = null,
    )
    {
    }

    public static function new(Context $context, ?string $message = null): self
    {
        return new self($context, $message);
    }

    public function run(): void
    {
        $process = run(
            command: [
                'git',
                'status',
                '--porcelain',
            ],
            context: $this->context
        );

        if (empty($process->getOutput())) {
            return;
        }

        throw new \RuntimeException($this->message ?: 'There are uncommitted changes in your working directory.');
    }
}