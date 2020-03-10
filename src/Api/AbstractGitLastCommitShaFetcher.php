<?php declare(strict_types=1);

namespace src\Api;

use Console\Api\Response\GitLastCommitSha;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use src\Api\Exceptions\ApiException;

abstract class AbstractGitLastCommitShaFetcher implements GitLastCommitShaFetcherInterface
{
    /**
     * @var Client
     */
    protected Client $client;

    /**
     * AbstractGitLastCommitShaFetcher constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $url
     * @return GitLastCommitSha
     */
    protected function getShaFromApi(string $url): GitLastCommitSha
    {
        $response = $this->makeGetRequest($url);
        return $this->decodeResponse($response->getBody()->getContents());
    }

    /**
     * @param string $url
     * @return ResponseInterface
     * @throws ApiException
     */
    abstract protected function makeGetRequest(string $url): ResponseInterface;

    /**
     * @param string $response
     * @return GitLastCommitSha
     * @throws ApiException
     */
    abstract protected function decodeResponse(string $response): GitLastCommitSha;
}