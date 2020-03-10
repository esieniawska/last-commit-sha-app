<?php declare(strict_types=1);

namespace src\Cli\Validators;

interface ValidatorInterface
{
    /**
     * @param $value
     * @return bool
     */
    public function isValid($value): bool;
}