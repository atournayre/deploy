<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Configuration;

final readonly class Config
{
    private function __construct(
        public ConfigApp $app,
        public ConfigBranches $branches,
        public ConfigDirectories $directories,
        public ConfigBin $bin,
        public ConfigComposer $composer,
    )
    {
    }

    public static function new(): self
    {
        $path = getcwd() . '/../tools/castor/.env';

        assert(file_exists($path), 'Unable to find .env file.');

        $ini = parse_ini_file($path);

        return new self(
            app: new ConfigApp($ini['APP_ENV'], $ini['APP_DEBUG']),
            branches: new ConfigBranches(
                $ini['MAIN_BRANCH'],
                $ini['DEVELOP_BRANCH'],
                $ini['MAIN_BRANCH'],
                new ConfigBranchesPatterns(
                    $ini['RELEASE_BRANCH'],
                    $ini['HOTFIX_BRANCH'],
                    $ini['FIX_BRANCH'],
                    $ini['UPDATE_DEPENDENCIES_BRANCH'],
                )
            ),
            directories: new ConfigDirectories($ini['APP_DIRECTORY'], $ini['PATCH_DIRECTORY']),
            bin: new ConfigBin(
                $ini['PHP_BIN'],
                $ini['COMPOSER_BIN'],
                $ini['CASTOR_BIN'],
                $ini['PHP_BIN'],
            ),
            composer: new ConfigComposer($ini['COMPOSER_JSON_PATH']),
        );
    }
}