<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Rules\Git;

use Atournayre\Deploy\Contracts\RuleInterface;
use Castor\Context;
use function Castor\run;

final readonly class GitMerge implements RuleInterface
{
    public function __construct(
        private Context $context,
        private string  $branch,
    )
    {
    }

    public function execute(): void
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

        if ($process->getExitCode() !== 0) {
            throw new \RuntimeException('Merge failed.');
        }
    }
}