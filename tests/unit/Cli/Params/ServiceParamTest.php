<?php declare(strict_types=1);

namespace unit\Cli\Params;

use PHPUnit\Framework\TestCase;
use src\Cli\Errors\InvalidServiceException;
use src\Cli\Params\ServiceParam;

class ServiceParamTest extends TestCase
{
    public function testExceptionWhenSetNotAllowedValue(): void
    {
        $serviceParam = new ServiceParam('service', ['first', 'test'],'test');
        $this->expectException(InvalidServiceException::class);
        $serviceParam->setValue('--service=abc');
    }

    public function testCanSetAllowedValue(): void
    {
        $serviceParam = new ServiceParam('service', ['first', 'test'],'test');
        $serviceParam->setValue('--service=test');
        $this->assertEquals('test', $serviceParam->getValue());
    }

    public function testGetDefaultValueWhenNoValue(): void
    {
        $serviceParam = new ServiceParam('service', ['first', 'test'],'test');
        $this->assertEquals('test', $serviceParam->getServiceValue());
    }
}