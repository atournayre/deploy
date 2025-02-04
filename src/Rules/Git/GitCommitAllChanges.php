<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Rules\Git;

use Atournayre\Deploy\Contracts\RuleInterface;
use Castor\Context;
use function Castor\run;

final readonly class GitCommitAllChanges implements RuleInterface
{
    public function __construct(
        private Context $context,
        private string  $message,
    )
    {
    }

    public function execute(): void
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