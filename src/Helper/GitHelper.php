<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Helper;

use Castor\Context;
use function Castor\run;

final readonly class GitHelper
{
    public function __construct(
        private Context $context,
    )
    {
    }

    public function lastBranch(string $branchPattern): string
    {
        $process = run(
            command: [
                'git',
                'branch',
                '--list',
                $branchPattern,
                '--sort=-committerdate',
            ],
            context: $this->context->withQuiet(),
        );

        $branches = array_filter(
            explode("\n", trim($process->getOutput()))
        );

        $lastBranch = !empty($branches)
            ? trim(str_replace('* ', '', $branches[0]))
            : null;

        return $lastBranch ?? throw new \RuntimeException('Unable to get last '.$branchPattern.' branch.');
    }

    public function listBranches(string $branchPattern): array
    {
        $process = run(
            command: [
                'git',
                'branch',
                '--list',
                $branchPattern,
            ],
            context: $this->context->withQuiet(),
        );

        $branches = array_filter(
            explode("\n", trim($process->getOutput()))
        );

        return array_map(
            fn(string $branch) => trim(str_replace('* ', '', $branch)),
            $branches
        );
    }
}