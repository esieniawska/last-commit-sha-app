<?php declare(strict_types=1);

namespace unit\Cli\Params;

use PHPUnit\Framework\TestCase;
use src\Cli\Params\CliParam;
use src\Cli\Params\Param;

class CliParamTest extends TestCase
{
    public function testGetCorrectParamInstance(): void
    {
        $param = new Param('abc');
        $cliParam = new CliParam($param);
        $this->assertInstanceOf(Param::class, $cliParam->getParam());
    }

    public function testCanBeCreatedRequiredParam(): void
    {
        $param = new Param('abc');
        $cliParam = new CliParam($param);
        $this->assertTrue($cliParam->isRequired());
    }
}