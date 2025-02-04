<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Rules\Application;

use Atournayre\Deploy\Contracts\RuleInterface;
use Castor\Context;

final readonly class ApplicationUpdateVersion implements RuleInterface
{
    public function __construct(
        private Context $context,
        private string $version,
    )
    {
    }

    public function execute(): void
    {
        $composerFile = $this->context['COMPOSER_JSON_PATH'];

        if (null === $composerFile) {
            throw new \RuntimeException('Unable to get app version because COMPOSER_JSON_PATH is not defined.');
        }

        if (!file_exists($composerFile)) {
            throw new \RuntimeException('Unable to get app version because composer.json file does not exist.');
        }

        $composer = json_decode(file_get_contents($composerFile), true);

        $composer['version'] = $this->version;

        file_put_contents($composerFile, json_encode($composer, JSON_PRETTY_PRINT));
    }
}
