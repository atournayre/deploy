<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Rules\Git;

use Atournayre\Deploy\Contracts\RuleInterface;
use Castor\Context;
use function Castor\run;

final readonly class GitPush implements RuleInterface
{
    public function __construct(
        private Context $context,
        private string  $remote,
        private string  $branch,
    )
    {
    }

    public function execute(): void
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