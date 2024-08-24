<?php

namespace Ephect\Samples;

use Ephect\Framework\CLI\Console;
use Ephect\Framework\CLI\ConsoleColors;
use Ephect\Framework\Modules\ModuleManifestEntity;
use Ephect\Framework\Modules\ModuleManifestReader;
use Ephect\Framework\Utils\File;

class Common
{
    public static function getModuleDir()
    {
        return  dirname(__DIR__, 2) . DIRECTORY_SEPARATOR;
    }

    public static function getModuleSrcDir()
    {
        return  dirname(__DIR__) . DIRECTORY_SEPARATOR;
    }

    public static function getModuleConfDir()
    {
        return  dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . REL_CONFIG_DIR;
    }

    public static function getModuleManifest(): ModuleManifestEntity
    {
        $manifestReader = new ModuleManifestReader();
        return $manifestReader->read(Common::getModuleConfDir());
    }

    public function createCommonTrees(): void
    {
        $common = self::getModuleSrcDir() . 'Assets' . DIRECTORY_SEPARATOR . 'Common';

        Console::writeLine(ConsoleColors::getColoredString("Publishing Common files...", ConsoleColors::BLUE));
        
        $this->publishConfigFiles($common);
        $this->publishAppFiles($common);
    }

    private function publishConfigFiles(string $commonDir): void
    {
        File::safeMkDir(CONFIG_DIR);
        $destDir = realpath(CONFIG_DIR);

        $srcDir = $commonDir . DIRECTORY_SEPARATOR . 'config';

        $this->publisFiles($srcDir, $destDir);
    }

    private function publishAppFiles(string $commonDir): void
    {
        $srcDir = $commonDir . DIRECTORY_SEPARATOR . 'app';

        File::safeMkDir(CONFIG_DOCROOT);
        $destDir = realpath(CONFIG_DOCROOT);

        $this->publisFiles($srcDir, $destDir);
    }

    private function publisFiles(string $srcDir, string $destDir): void
    {
        if (!file_exists($srcDir) || !file_exists($destDir)) {
            Console::writeLine("Stopping! source dir %s or destination dir %s does not exist.", $srcDir, $destDir);
            return;
        }

        $tree = File::walkTreeFiltered($srcDir);
        Console::writeLine(ConsoleColors::getColoredString("Source directory: $srcDir", ConsoleColors::GREEN));
        Console::writeLine(ConsoleColors::getColoredString("Destination directory: $destDir", ConsoleColors::GREEN));
        foreach ($tree as $filePath) {
            Console::writeLine("Copying file: %s", $filePath);
            File::safeWrite($destDir . $filePath, '');
            copy($srcDir . $filePath, $destDir . $filePath);
        }
    }

    public function requireTree(string $treePath): object
    {
        $tree = File::walkTreeFiltered($treePath, ['php']);
        $result = ['path' => $treePath, 'tree' => $tree];

        return (object)$result;
    }

    public function displayTree($path): void
    {
        $tree = File::walkTreeFiltered($path);
        Console::writeLine($tree);
    }
}