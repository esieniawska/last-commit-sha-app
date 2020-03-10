<?php declare(strict_types=1);

namespace src\Api;

use src\Api\Exceptions\ApiException;
use Console\Api\Response\GitLastCommitSha;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;

class GithubLastCommitShaFetcher extends AbstractGitLastCommitShaFetcher
{
    /**
     * @param string $ownerRepository
     * @param string $branch
     * @return GitLastCommitSha
     */
    public function getLastCommitSha(string $ownerRepository, string $branch): GitLastCommitSha
    {
        $url = "https://api.github.com/repos/$ownerRepository/branches/$branch";

        return $this->getShaFromApi($url);
    }

    /**
     * @param string $url
     * @return ResponseInterface
     * @throws ApiException
     */
    protected function makeGetRequest(string $url): ResponseInterface
    {
        try {
            return $this->client->request('GET', $url, ['json']);
        } catch (ClientException $e) {
            throw new ApiException('Failed to retrieve data, check that the parameters are correct');
        }
    }

    /**
     * @param string $response
     * @return GitLastCommitSha
     * @throws ApiException
     */
    protected function decodeResponse(string $response): GitLastCommitSha
    {
        $json = json_decode($response, true);

        if (!isset($json['commit']) || !isset($json['commit']['sha'])) {
            throw new ApiException('No sha in response');
        }

        return new GitLastCommitSha($json['commit']['sha']);
    }
}