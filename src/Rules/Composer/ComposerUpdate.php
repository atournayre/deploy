<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Rules\Composer;

use Atournayre\Deploy\Contracts\RuleInterface;
use Castor\Context;
use function Castor\run;

final readonly class ComposerUpdate implements RuleInterface
{
    public function __construct(
        private Context $context,
        private array $options = [],
    )
    {
    }

    public function execute(): void
    {
        run(
            command: array_merge([
                'composer',
                'update',
            ], $this->options),
            context: $this->context,
        );
    }
}