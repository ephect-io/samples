<?php

namespace Ephect\Samples\MakeQuickStart;

use Ephect\Framework\Commands\AbstractCommand;
use Ephect\Framework\Commands\Attributes\CommandDeclaration;
use Ephect\Samples\CommonLib;

#[CommandDeclaration(verb: "make", subject: "quickstart")]
#[CommandDeclaration(desc: "Create the quickstart application tree.")]
class Main extends AbstractCommand
{
    public function run(): int
    {
        $egg = new CommonLib($this->application);
        $egg->createCommonTrees();

        $lib = new Lib($this->application);
        $lib->createQuickstart();

        return 0;
    }
}
