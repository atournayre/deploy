<?php
declare(strict_types=1);

namespace Atournayre\Deploy\Helper;

use Castor\Context;
use function Castor\load_dot_env;

final readonly class ContextHelper
{
    private function __construct(
        private Context $context,
    )
    {
    }

    public static function new(): self
    {
        $path = getcwd() . '/../tools/castor/.env';

        assert(file_exists($path), 'Unable to find .env file.');

        $dotEnv = load_dot_env($path);

        $context = new Context(
            data: $dotEnv,
            workingDirectory: $dotEnv['APP_DIRECTORY']
        );

        return new self($context);
    }

    public function context(): Context
    {
        return $this->context;
    }
}