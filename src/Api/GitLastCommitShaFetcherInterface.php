<?php declare(strict_types=1);

namespace src\Api;

use Console\Api\Response\GitLastCommitSha;

interface GitLastCommitShaFetcherInterface
{
    /**
     * @param string $ownerRepository
     * @param string $branch
     * @return GitLastCommitSha
     */
    public function getLastCommitSha(string $ownerRepository, string $branch): GitLastCommitSha;
}