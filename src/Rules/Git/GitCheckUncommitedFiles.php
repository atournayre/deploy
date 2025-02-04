<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Rules\Git;

use Atournayre\Deploy\Contracts\RuleInterface;
use Castor\Context;
use function Castor\run;

final readonly class GitCheckUncommitedFiles implements RuleInterface
{
    public function __construct(
        private Context $context,
        private ?string $message = null,
    )
    {
    }

    public function execute(): void
    {
        $this->checkUncommitedFiles();
    }

    private function checkUncommitedFiles(): void
    {
        $process = run(
            command: [
                'git',
                'status',
                '--porcelain',
            ],
            context: $this->context
        );

        if (!empty($process->getOutput())) {
            throw new \RuntimeException($this->message ?: 'There are uncommitted changes in your working directory.');
        }
    }
}