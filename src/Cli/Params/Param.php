<?php declare(strict_types=1);

namespace src\Cli\Params;

use src\Cli\Errors\InvalidParamException;
use src\Cli\Validators\ValidatorInterface;

class Param
{
    protected ?ValidatorInterface $validator = null;
    protected string $name;
    protected ?string $value = null;

    /**
     * Param constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param ValidatorInterface $validator
     */
    public function setValidator(ValidatorInterface $validator): void
    {
        $this->validator = $validator;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        if ($this->checkIsValidValue($value)) {
            $this->value = $value;
        } else {
            throw new InvalidParamException("Invalid value for '$this->name': $value");
        }
    }

    /**
     * @param string $value
     * @return bool
     */
    protected function checkIsValidValue(string $value): bool
    {
        $isValidValue = !is_null($this->validator) && $this->validator->isValid($value);

        return is_null($this->validator) || $isValidValue;
    }

    /**
     * @return bool
     */
    public function isNullValue(): bool
    {
        return is_null($this->getValue());
    }
}