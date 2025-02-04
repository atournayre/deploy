<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Rules\Patch;

use Atournayre\Deploy\Configuration\Config;
use Atournayre\Deploy\Helper\ApplicationHelper;
use Castor\Context;
use function Castor\fs;
use function Castor\io;
use function Castor\run;
use function Symfony\Component\String\u;

final readonly class PatchApply
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

    public function apply(): void
    {
        $appVersion = (new ApplicationHelper($this->context))
            ->version()
        ;

        $patch = u($this->config->directories->patch)
            ->append('/', $appVersion, '.php')
            ->toString()
        ;

        if (!fs()->exists($patch)) {
            io()->note('No patch to apply for version '.$appVersion);
            return;
        }

        io()->title('Apply patch '.$appVersion);

        run(
            command: [
                $this->config->bin->php,
                $this->config->bin->symfony,
                'patch:'.$patch,
            ],
            context: $this->context,
        );
    }
}