<?php

namespace Kubinyete\Fraugster\Model;

use Kubinyete\Fraugster\Model\Exception\DomainException;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class Phone
{
    protected const DEFAULT_COUNTRY   = 'BR';
    protected const DEFAULT_FORMAT    = PhoneNumberFormat::E164;

    protected string $value;

    public function __construct(
        string $value
    ) {
        $this->value = $this->assertValidPhone($value);
    }

    protected final function assertValidPhone(string $value): string
    {
        $util = PhoneNumberUtil::getInstance();
        $number = $this->parseNumber($value, $util);

        $this->assertValid($number, $util);

        return $this->formatNumber($number, $util);
    }

    protected function assertValid(PhoneNumber $number, PhoneNumberUtil $util): void
    {
    }

    protected function formatNumber(PhoneNumber $number, PhoneNumberUtil $util): string
    {
        return $util->format($number, self::DEFAULT_FORMAT);
    }

    protected function parseNumber(string $value, PhoneNumberUtil $lib): PhoneNumber
    {
        try {
            $parsedNumber = $lib->parse($value, self::DEFAULT_COUNTRY);
        } catch (NumberParseException $e) {
            $parsedNumber = null;
        }

        DomainException::assert($parsedNumber, "Value is not a phone number.");
        DomainException::assert($lib->isValidNumber($parsedNumber), "Value is not a valid phone number.");

        return $parsedNumber;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
