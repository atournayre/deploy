<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Rules\Symfony;

use Atournayre\Deploy\Configuration\Config;
use Castor\Context;
use function Castor\run;

final readonly class SymfonyCacheClear
{
    private function __construct(
        private Context $context,
        private Config $config,
    )
    {
    }

    public static function new(Context $context, Config $config): self
    {
        return new self($context, $config);
    }

    private function run(): void
    {
        run(
            command: [
                $this->config->bin->php,
                $this->config->bin->symfony,
                'cache:clear',
            ],
            context: $this->context,
        );
    }
}
