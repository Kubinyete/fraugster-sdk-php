<?php

namespace Kubinyete\Fraugster\Model;

use Kubinyete\Fraugster\Model\Exception\DomainException;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;

class FixedLinePhone extends Phone
{
    protected function assertValid(PhoneNumber $number, PhoneNumberUtil $lib): void
    {
        DomainException::assert($lib->getNumberType($number) == PhoneNumberType::FIXED_LINE, "Number is not a fixed line phone number");
    }
}
