<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Rules\Git;

use Atournayre\Deploy\Contracts\RuleInterface;
use Castor\Context;
use function Castor\run;

final readonly class GitUpdateBranch implements RuleInterface
{
    public function __construct(
        private Context $context,
        private string  $branch,
    )
    {
    }

    public function execute(): void
    {
        run(
            command: [
                'git',
                'fetch',
            ],
            context: $this->context
        );

        run(
            command: [
                'git',
                'checkout',
                $this->branch,
            ],
            context: $this->context
        );

        run(
            command: [
                'git',
                'pull',
                'origin',
                $this->branch,
            ],
            context: $this->context
        );
    }
}