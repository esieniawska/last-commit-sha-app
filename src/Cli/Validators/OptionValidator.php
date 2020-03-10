<?php declare(strict_types=1);

namespace src\Cli\Validators;

class OptionValidator extends RegularExpressionValidator
{
    /**
     * OptionValidator constructor.
     * @param string $option
     */
    public function __construct(string $option)
    {
        $pattern = "/^(--$option=).*$/";
        parent::__construct($pattern);
    }
}