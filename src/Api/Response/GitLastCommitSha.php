<?php declare(strict_types=1);

namespace Console\Api\Response;

class GitLastCommitSha
{
    private string $sha;

    /**
     * GitLastCommitSha constructor.
     * @param string $sha
     */
    public function __construct(string $sha)
    {
        $this->sha = $sha;
    }

    /**
     * @return string
     */
    public function getSha(): string
    {
        return $this->sha;
    }
}