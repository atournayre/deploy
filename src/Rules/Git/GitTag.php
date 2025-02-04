<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Rules\Git;

use Atournayre\Deploy\Contracts\RuleInterface;
use Castor\Context;
use function Castor\run;

final readonly class GitTag implements RuleInterface
{
    public function __construct(
        private Context $context,
        private string  $tag,
    )
    {
    }

    public function execute(): void
    {
        run(
            command: [
                'git',
                'tag',
                $this->tag,
            ],
            context: $this->context,
        );

        run(
            command: [
                'git',
                'push',
                '--tags',
            ],
            context: $this->context,
        );
    }
}