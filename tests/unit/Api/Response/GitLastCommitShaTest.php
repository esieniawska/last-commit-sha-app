<?php declare(strict_types=1);

namespace unit\Api\Response;

use Console\Api\Response\GitLastCommitSha;
use PHPUnit\Framework\TestCase;

class GitLastCommitShaTest extends TestCase
{
    public function testCorrectGetShaValue(): void
    {
        $commitSha = new GitLastCommitSha('123456');
        $this->assertEquals('123456', $commitSha->getSha());
    }
}