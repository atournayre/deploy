<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Rules\Git;

use Atournayre\Deploy\Contracts\RuleInterface;
use Castor\Context;
use function Castor\run;

final readonly class GitCreateBranch implements RuleInterface
{
    public function __construct(
        private Context $context,
        private string  $branch,
        private ?string $startPoint = null,
    )
    {
    }

    public function execute(): void
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