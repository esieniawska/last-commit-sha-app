<?php declare(strict_types=1);

namespace src\Cli\Validators;

interface ValidatorInterface
{
    /**
     * @param string $value
     * @return bool
     */
    public function isValid(string $value): bool;
}