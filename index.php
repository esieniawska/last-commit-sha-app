<?php declare(strict_types=1);

use GuzzleHttp\Client;
use src\Api\GitLastCommitShaFetcherFactory;
use src\Cli\CliParamsReader;

require __DIR__ . '/vendor/autoload.php';

spl_autoload_register(function ($class) {
    $path = realpath(__DIR__) . '/';
    $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $path . $class . '.php');
    require $fileName;
});

unset($argv[0]);

try {
    $cliReader = new CliParamsReader($argv, ['github']);
    $factory = new GitLastCommitShaFetcherFactory( new Client());
    $fetcher = $factory->createFetcher($cliReader->getServiceName());
    $lastCommitSha = $fetcher->getLastCommitSha($cliReader->getOwnerRepo(), $cliReader->getBranchName());
    echo $lastCommitSha->getSha();
    echo "\n";
    exit();
} catch (\Exception $exception) {
    echo $exception->getMessage();
    echo "\n";
    exit();
}

