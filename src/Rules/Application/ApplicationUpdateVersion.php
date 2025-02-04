<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Rules\Application;

use Atournayre\Deploy\Configuration\Config;

final readonly class ApplicationUpdateVersion
{
    private function __construct(
        private Config $config,
        private string $version,
    )
    {
    }

    public static function new(Config $config, string $version): self
    {
        return new self($config, $version);
    }

    public function updateComposerJson(): void
    {
        $composerFile = $this->config->composer->jsonPath;

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
