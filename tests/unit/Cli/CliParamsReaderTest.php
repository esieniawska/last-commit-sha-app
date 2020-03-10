<?php declare(strict_types=1);

namespace unit\Cli;

use PHPUnit\Framework\TestCase;
use src\Cli\CliParamsReader;
use src\Cli\Errors\InvalidParamException;

class CliParamsReaderTest extends TestCase
{
    public function testExceptionWhenUnknownArgument(): void
    {
        $this->expectException(InvalidParamException::class);
        new CliParamsReader(
            [
                'test', 'test1/test', 'test3'
            ],
            ['test']
        );
    }

    public function testExceptionWhenNotSetRequiredParam(): void
    {
        $this->expectException(InvalidParamException::class);

        new CliParamsReader(
            [
                'test1/test'
            ],
            ['test']
        );
    }

    public function testGetGithubServiceWhenNotSet(): void
    {
        $cliReader = new CliParamsReader(
            [
                'test1/test', 'master'
            ],
            ['test']
        );

        $this->assertEquals('github', $cliReader->getServiceName());
    }

    public function testGetTestService(): void
    {
        $cliReader = new CliParamsReader(
            [
                'test1/test', 'master', '--service=test'
            ],
            ['test', 'test2']);

        $this->assertEquals('test', $cliReader->getServiceName());
    }

    public function testGetCorrectBranchName(): void
    {
        $branchName = 'master';
        $cliReader = new CliParamsReader(
            [
                'test1/test', '--service=test', $branchName,
            ],
            ['test', 'test2']);

        $this->assertEquals($branchName, $cliReader->getBranchName());
    }

    public function testGetCorrectOwnerRepo(): void
    {
        $ownerRepo = 'test1/test2';
        $cliReader = new CliParamsReader(
            [
                'dev', $ownerRepo, '--service=test'
            ],
            ['test', 'test2']);

        $this->assertEquals($ownerRepo, $cliReader->getOwnerRepo());
    }
}