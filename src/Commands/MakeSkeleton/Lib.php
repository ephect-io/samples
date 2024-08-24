<?php

namespace Ephect\Samples\Commands\MakeSkeleton;

use Ephect\Framework\Commands\AbstractCommandLib;
use Ephect\Framework\Utils\File;
use Ephect\Modules\WebComponent\Common;

class Lib extends AbstractCommandLib
{

    public function makeSkeleton(): void
    {
        $sample = Common::getModuleSrcDir() . 'Assets' . DIRECTORY_SEPARATOR . 'Skeleton';

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

