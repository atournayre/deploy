<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Helper;

use Castor\Context;
use function Symfony\Component\String\u;

final readonly class ApplicationHelper
{
    public function __construct(
        private Context $context,
    )
    {
    }

    public function version(): string
    {
        $composerFile = $this->context['COMPOSER_JSON_PATH'];

        if (null === $composerFile) {
            throw new \RuntimeException('Unable to get app version because COMPOSER_JSON_PATH is not defined.');
        }

        if (!file_exists($composerFile)) {
            throw new \RuntimeException('Unable to get app version because composer.json file does not exist.');
        }

        $composer = json_decode(file_get_contents($composerFile), true);

        return $composer['version'] ?? throw new \RuntimeException('Unable to get app version.');
    }

    public function fixBranchName(string $hotfixBranchName, string $issueNumber): string
    {
        return u($hotfixBranchName)
            ->replace('hotfix/', 'fix/')
            ->append('-', $issueNumber)
            ->toString()
        ;
    }
    public function hotfixBranchName(string $version): string
    {
        return 'hotfix/'.$version;
    }
}