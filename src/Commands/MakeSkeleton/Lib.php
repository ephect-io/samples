<?php

namespace Ephect\Samples\MakeSkeleton;

use Ephect\Framework\Commands\AbstractCommandLib;
use Ephect\Framework\Utils\File;

class Lib extends AbstractCommandLib
{

    public function makeSkeleton(): void
    {
        $sample = SRC_ROOT . 'Assets' . DIRECTORY_SEPARATOR . 'Skeleton';

        File::safeMkDir(siteSrcPath());
        $destDir = realpath(siteSrcPath());

        if (!file_exists($sample) || !file_exists($destDir)) {
            return;
        }

        $tree = File::walkTreeFiltered($sample);

        foreach ($tree as $filePath) {
            File::safeWrite($destDir . $filePath, '');
            copy($sample . $filePath, $destDir . $filePath);
        }
    }
}

