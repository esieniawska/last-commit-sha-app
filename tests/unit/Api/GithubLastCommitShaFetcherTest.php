<?php declare(strict_types=1);

namespace unit\Api;

use Console\Api\Response\GitLastCommitSha;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use src\Api\Exceptions\ApiException;
use src\Api\GithubLastCommitShaFetcher;

class GithubLastCommitShaFetcherTest extends TestCase
{
    public function testCorrectGetGitCommitShaObject(): void
    {
        $client = $this->prophesize(Client::class);
        $response = $this->prophesize(ResponseInterface::class);
        $stream = $this->prophesize(StreamInterface::class);
        $apiResponse = ['commit' => ['sha' => '1456']];
        $stream->getContents()->willReturn(json_encode($apiResponse));
        $response->getBody()->willReturn($stream->reveal());
        $client->request('GET', Argument::type('string'), ['json'])->willReturn($response->reveal());

        $fetcher = new GithubLastCommitShaFetcher($client->reveal());
        $this->assertInstanceOf(GitLastCommitSha::class, $fetcher->getLastCommitSha('test/test1', 'dev'));
    }

    public function testGetApiExceptionWhenClientException(): void
    {
        $client = $this->prophesize(Client::class);
        $clientException = $this->prophesize(ClientException::class);
        $client->request('GET', Argument::type('string'), ['json'])->willThrow($clientException->reveal());

        $this->expectException(ApiException::class);
        $fetcher = new GithubLastCommitShaFetcher($client->reveal());
        $fetcher->getLastCommitSha('test/test1', 'dev');
    }

    public function testGetApiExceptionWhenNoCommitSha(): void
    {
        $client = $this->prophesize(Client::class);
        $response = $this->prophesize(ResponseInterface::class);
        $stream = $this->prophesize(StreamInterface::class);
        $apiResponse = [];
        $stream->getContents()->willReturn(json_encode($apiResponse));
        $response->getBody()->willReturn($stream->reveal());
        $client->request('GET', Argument::type('string'), ['json'])->willReturn($response->reveal());

        $fetcher = new GithubLastCommitShaFetcher($client->reveal());
        $this->expectException(ApiException::class);
        $fetcher->getLastCommitSha('test/test1', 'dev');
    }
}