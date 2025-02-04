<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Rules\Composer;

use Castor\Context;
use function Castor\run;

final readonly class ComposerUpdate
{
    private function __construct(
        private Context $context,
    )
    {
    }

    public static function new(Context $context): self
    {
        return new self($context);
    }

    public function run(): void
    {
        run(
            command: [
                'composer',
                'update',
            ],
            context: $this->context,
        );
    }

    public function dryRun(): void
    {
        run(
            command: [
                'composer',
                'update',
                '--dry-run',
            ],
            context: $this->context,
        );
    }
}