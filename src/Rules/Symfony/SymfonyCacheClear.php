<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Rules\Symfony;

use Atournayre\Deploy\Contracts\RuleInterface;
use Castor\Context;
use function Castor\io;
use function Castor\run;

final readonly class SymfonyCacheClear implements RuleInterface
{
    public function __construct(
        private Context $context,
    )
    {
    }

    public function execute(): void
    {
        io()->section('Clearing cache');
        $this->clearCache();
        io()->success('Cache cleared');
    }

    private function clearCache(): void
    {
        run(
            command: [
                'php',
                'bin/console',
                'cache:clear',
            ],
            context: $this->context,
        );
    }
}
