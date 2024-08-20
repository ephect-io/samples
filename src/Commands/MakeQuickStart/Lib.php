<?php

namespace Ephect\Samples\MakeQuickStart;

use Ephect\Framework\Utils\File;

class Lib
{

    public function createQuickstart(): void
    {
        $sample = SRC_ROOT . 'Assets' . DIRECTORY_SEPARATOR . 'QuickStart';

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

