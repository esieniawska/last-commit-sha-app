<?php declare(strict_types=1);

namespace unit\Api;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use src\Api\Exceptions\ApiException;
use src\Api\GitLastCommitShaFetcherFactory;
use src\Api\GitLastCommitShaFetcherInterface;

class GitLastCommitShaFactoryTest extends TestCase
{
    public function testExceptionWhenUnknownApiInstance(): void
    {
        $client = $this->prophesize(Client::class);
        $this->expectException(ApiException::class);
        $factory = new GitLastCommitShaFetcherFactory( $client->reveal());
        $factory->createFetcher('test');
    }

    public function testCorrectCreateFetcherSha(): void
    {
        $client = $this->prophesize(Client::class);
        $factory = new GitLastCommitShaFetcherFactory( $client->reveal());
        $fetcher = $factory->createFetcher('github');
        $this->assertInstanceOf(GitLastCommitShaFetcherInterface::class, $fetcher);
    }
}