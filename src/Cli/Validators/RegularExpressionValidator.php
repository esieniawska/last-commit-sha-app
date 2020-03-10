<?php declare(strict_types=1);

namespace src\Cli\Validators;

class RegularExpressionValidator implements ValidatorInterface
{
    protected string $pattern;

    /**
     * RegularExpressionValidator constructor.
     * @param string $pattern
     */
    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * @param $value
     * @return bool
     */
    public function isValid($value): bool
    {
        return preg_match($this->pattern, $value) === 1;
    }
}