<?php declare(strict_types=1);

namespace src\Cli\Params;

class CliParam
{
    protected bool $isRequired;
    protected Param $param;

    /**
     * CliParam constructor.
     * @param Param $param
     * @param bool $isRequired
     */
    public function __construct(Param $param, bool $isRequired = true)
    {
        $this->param = $param;
        $this->isRequired = $isRequired;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->isRequired;
    }

    /**
     * @return Param
     */
    public function getParam(): Param
    {
        return $this->param;
    }
}