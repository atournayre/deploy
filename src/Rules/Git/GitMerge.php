<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Rules\Git;

use Castor\Context;
use function Castor\run;

final readonly class GitMerge
{
    private function __construct(
        private Context $context,
        private string $branch,
    )
    {
    }

    public static function new(Context $context, string $branch): self
    {
        return new self($context, $branch);
    }

    public function run(): void
    {
        $process = run(
            command: [
                'git',
                'merge',
                '--no-ff',
                '-X',
                'theirs',
                $this->branch,
            ],
            context: $this->context->withQuiet(),
        );

        if ($process->getExitCode() === 0) {
            return;
        }

        throw new \RuntimeException('Merge failed.');
    }
}