<?php

namespace Kubinyete\Fraugster\Model;

use Kubinyete\Fraugster\Model\Exception\DomainException;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;

class MobilePhone extends Phone
{
    protected function assertValid(PhoneNumber $number, PhoneNumberUtil $lib): void
    {
        DomainException::assert($lib->getNumberType($number) == PhoneNumberType::MOBILE, "Number is not a mobile phone number");
    }
}
