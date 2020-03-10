<?php declare(strict_types=1);

namespace src\Api;

use GuzzleHttp\Client;
use src\Api\Exceptions\ApiException;
use src\Cli\Errors\InvalidParamException;

class GitLastCommitShaFetcherFactory
{
    private Client $client;

    /**
     * GitLastCommitShaFetcher constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $name
     * @return GitLastCommitShaFetcherInterface
     * @throws ApiException
     */
    public function createFetcher(string $name): GitLastCommitShaFetcherInterface
    {
        switch ($name) {
            case 'github':
                return new GithubLastCommitShaFetcher($this->client);
            default:
                throw new ApiException(sprintf('Undefined API instance for: "%s"', $name));
        }
    }
}