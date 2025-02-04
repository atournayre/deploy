<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Rules\Hook;

use Atournayre\Deploy\Configuration\Config;
use Castor\Context;
use function Castor\io;
use function Castor\run;

final readonly class Hook
{
    private function __construct(
        private Context $context,
        private Config $config,
        private string $hook,
    )
    {
    }

    public static function new(Context $context, Config $config, string $hook): self
    {
        return new self($context, $config, $hook);
    }

    public function apply(): void
    {
        io()->title('Apply patch '.$this->hook);

        run(
            command: [
                $this->config->bin->php,
                $this->config->bin->symfony,
                $this->hook,
            ],
            context: $this->context,
        );
    }
}