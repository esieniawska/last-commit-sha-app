<?php declare(strict_types=1);

namespace src\Cli\Params;

use src\Cli\Errors\InvalidServiceException;

class ServiceParam extends Param
{
    protected array $allowedOptions;
    private string $defaultValue;

    /**
     * ServiceParam constructor.
     * @param string $name
     * @param array $allowedOptions
     * @param string $defaultValue
     */
    public function __construct(string $name, array $allowedOptions, string $defaultValue)
    {
        parent::__construct($name);

        $this->allowedOptions = $allowedOptions;
        $this->defaultValue = $defaultValue;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        parent::setValue($value);

        preg_match("/^--($this->name)(=(.*))?$/", $value, $matches);
        $this->value = isset($matches[3]) ? $matches[3] : null;

        if (!in_array($this->value, $this->allowedOptions)) {
            throw new InvalidServiceException("Unknown $this->name: '$this->value' in allowed options");
        }
    }

    /**
     * @return string
     */
    public function getServiceValue(): string
    {
        return !is_null($this->value) ? $this->value : $this->defaultValue;
    }
}