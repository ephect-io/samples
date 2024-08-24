<?php

namespace Ephect\Samples\Commands\MakeQuickStart;

use Ephect\Framework\CLI\Console;
use Ephect\Framework\CLI\ConsoleColors;
use Ephect\Framework\Commands\AbstractCommandLib;
use Ephect\Framework\Utils\File;
use Ephect\Modules\WebComponent\Common;

class Lib extends AbstractCommandLib
{

    public function createQuickstart(): void
    {
        Console::writeLine(ConsoleColors::getColoredString("Publishing Skeleton files...", ConsoleColors::BLUE));

        $sample = Common::getModuleSrcDir() . 'Assets' . DIRECTORY_SEPARATOR . 'QuickStart';

        File::safeMkDir(siteSrcPath());
        $destDir = realpath(siteSrcPath());

        if (!file_exists($sample) || !file_exists($destDir)) {
            Console::writeLine("Stopping! Sample dir %s or destination dir %s does not exists.", $sample, $destDir);
            return;
        }

        $tree = File::walkTreeFiltered($sample);

        Console::writeLine(ConsoleColors::getColoredString("Source directory: $sample", ConsoleColors::GREEN));
        Console::writeLine(ConsoleColors::getColoredString("Destination directory: $destDir", ConsoleColors::GREEN));
        foreach ($tree as $filePath) {
            Console::writeLine("Copying file: %s", $filePath);
            File::safeWrite($destDir . $filePath, '');
            copy($sample . $filePath, $destDir . $filePath);
        }
    }
}

