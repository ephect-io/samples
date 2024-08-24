<?php

namespace Ephect\Samples;

use Ephect\Framework\CLI\Console;
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
        $src_dir = $common . DIRECTORY_SEPARATOR . 'config';

        File::safeMkDir(CONFIG_DIR);
        $destDir = realpath(CONFIG_DIR);

        $tree = File::walkTreeFiltered($src_dir);

        foreach ($tree as $filePath) {
            File::safeWrite($destDir . $filePath, '');
            copy($src_dir . $filePath, $destDir . $filePath);
        }

        $src_dir = $common . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Assets';

        File::safeMkDir(CONFIG_DOCROOT);
        $destDir = realpath(CONFIG_DOCROOT);

        $tree = File::walkTreeFiltered($src_dir);

        foreach ($tree as $filePath) {
            File::safeWrite($destDir . $filePath, '');
            copy($src_dir . $filePath, $destDir . $filePath);
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