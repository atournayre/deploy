<?php
declare(strict_types=1);

namespace Atournayre\Deploy;

use Castor\Attribute\AsTask;
use Symfony\Component\Finder\SplFileInfo;
use function Castor\fs;
use function Castor\io;
use function Symfony\Component\String\u;

#[AsTask(namespace: 'patch')]
function generate(string $version): void
{
    io()->section('Generate patch');

    $versionName = u($version)
        ->replace('.', '_')
        ->toString()
    ;

    $template = 'install/patch/X.Y.Z.php';
    $destination = 'install/patch/'.$version.'.php';

    fs()->copy($template, $destination);

    $file = new SplFileInfo($template, $template, $template);

    $content = u($file->getContents())
        ->replace('_PATCH_NUMBER_', $version)
        ->replace('_PATCH_NAME_', $versionName)
        ->toString()
    ;

    fs()->dumpFile($destination, $content);
}
