<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Rules\Patch;

use Atournayre\Deploy\Contracts\RuleInterface;
use Atournayre\Deploy\Helper\ApplicationHelper;
use Castor\Context;
use function Castor\fs;
use function Castor\io;
use function Castor\run;
use function Symfony\Component\String\u;

final readonly class PatchApply implements RuleInterface
{
    public function __construct(
        private Context $context,
    )
    {
    }

    public function execute(): void
    {
        $appVersion = (new ApplicationHelper($this->context))
            ->version()
        ;

        $patch = u($this->context['PATCH_DIRECTORY'])
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
                $this->context['PHP_BIN'],
                $this->context['BIN_CONSOLE'],
                'patch:'.$patch,
            ],
            context: $this->context,
        );
    }
}