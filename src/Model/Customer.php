<?php

namespace Kubinyete\Fraugster\Model;

use DateTime;
use DateTimeInterface;
use JsonSerializable;
use Kubinyete\Fraugster\Model\Exception\DomainException;
use Kubinyete\Fraugster\Util\DateUtil;

/**
 * @template T of Card
 */
class Customer implements JsonSerializable
{
    public function __construct(
        protected ?string $id,
        protected DateTimeInterface $birthDate,
        protected Email $email,
        protected Gender $gender,
        protected string $name,
        protected bool $existing,
        protected bool $existingMerchant,
        protected ?string $username = null,
        protected ?bool $verified = null,
    ) {
        $this->assertValid();
        $this->assertValidEmail();
    }

    //

    protected function assertValid(): void
    {
        DomainException::assert(is_null($this->id) || strlen($this->id), "Customer id is required");
        DomainException::assert(strlen($this->name), "Customer name is required");
        DomainException::assert(is_null($this->username) || strlen($this->username), "Customer username is required");
    }

    protected function assertValidEmail(): void
    {
        DomainException::assert(filter_var($this->email, FILTER_VALIDATE_EMAIL), "Customer email should be valid");
    }

    //

    public function jsonSerialize(): mixed
    {
        return [
            'cust_id' => $this->id,
            'cust_dob' => $this->birthDate?->format(DateUtil::RFC3339_DATE),
            'cust_email' => (string)$this->email,
            'cust_gender' => $this->gender->value,
            'cust_name' => $this->name,
            'cust_existing' => $this->existing,
            'cust_existing_merchant' => $this->existingMerchant,
            'customer_username' => $this->username,
            'customer_verified_account' => $this->verified,
        ];
    }
}
