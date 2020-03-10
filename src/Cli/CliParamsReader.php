<?php declare(strict_types=1);

namespace src\Cli;

use src\Cli\Errors\InvalidParamException;
use src\Cli\Params\BranchParam;
use src\Cli\Params\CliParam;
use src\Cli\Params\ServiceParam;
use src\Cli\Params\OwnerRepoParam;
use src\Cli\Params\Param;
use src\Cli\Validators\OptionValidator;
use src\Cli\Validators\RegularExpressionValidator;

class CliParamsReader
{
    protected array $params = [];
    const PARAM_BRANCH = 'branch';
    const PARAM_OWNER_REPO = 'owner/repo';
    const PARAM_SERVICE = 'service';

    public function __construct(array $arguments, array $allowedServices)
    {
        $this->createCliParams($allowedServices);
        $this->readParams($arguments);
    }

    /**
     * @param array $allowedServices
     */
    private function createCliParams(array $allowedServices): void
    {
        $this->createOwnerRepoParam();
        $this->createServiceParam($allowedServices);
        $this->createBranchParam();
    }

    private function createOwnerRepoParam(): void
    {
        $param = new Param(self::PARAM_OWNER_REPO);
        $validator = new RegularExpressionValidator('/^[^\/]+\/[^\/]+$/');
        $param->setValidator($validator);
        $this->addParam($param);
    }

    private function createServiceParam(array $allowedServices): void
    {
        $param = new ServiceParam(self::PARAM_SERVICE, $allowedServices, 'github');
        $param->setValidator(new OptionValidator(self::PARAM_SERVICE));
        $this->addParam($param, false);
    }

    private function createBranchParam(): void
    {
        $param = new Param(self::PARAM_BRANCH);
        $this->addParam($param);
    }

    /**
     * @param Param $param
     * @param bool $isRequired
     */
    private function addParam(Param $param, bool $isRequired = true): void
    {
        $this->params[$param->getName()] = new CliParam($param, $isRequired);
    }

    /**
     * @param string $name
     * @return Param
     */
    private function getParam(string $name): Param
    {
        return $this->params[$name]->getParam();
    }

    /**
     * @param array $arguments
     */
    public function readParams(array $arguments): void
    {
        $this->setValuesFromCli($arguments);
        $this->checkIfNumberOfArgumentsIsCorrected();
    }

    /**
     * @param array $arguments
     */
    private function setValuesFromCli(array $arguments): void
    {
        foreach ($arguments as $argument) {
            $correctArgument = false;
            foreach ($this->params as $cliParam) {
                try {
                    $param = $cliParam->getParam();
                    if ($param->isNullValue()) {
                        $param->setValue($argument);
                        $correctArgument = true;
                        break;
                    }
                } catch (InvalidParamException $exception) {
                    continue;
                }
            }

            if (!$correctArgument) {
                throw new InvalidParamException('Unknown argument: ' . $argument);
            }
        }
    }

    private function checkIfNumberOfArgumentsIsCorrected(): void
    {
        $errors = [];
        foreach ($this->params as $cliParam) {
            $param = $cliParam->getParam();
            if ($cliParam->isRequired() && $param->isNullValue()) {
                $errors[] = 'Param: ' . $param->getName() . ' is required';
            }
        }

        if (!empty($errors)) {
            throw new InvalidParamException(implode("\n", $errors));
        }
    }

    /**
     * @return string
     */
    public function getServiceName(): string
    {
        $service = $this->getParam(self::PARAM_SERVICE);

        return $service->getServiceValue();
    }

    /**
     * @return string
     */
    public function getBranchName(): string
    {
        return $this->getParam(self::PARAM_BRANCH)->getValue();
    }

    /**
     * @return string
     */
    public function getOwnerRepo(): string
    {
        return $this->getParam(self::PARAM_OWNER_REPO)->getValue();
    }
}