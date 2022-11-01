<?php

namespace Kubinyete\Fraugster\Model;

use DateTimeInterface;
use JsonSerializable;
use Kubinyete\Fraugster\Model\Exception\DomainException;

class Customer implements JsonSerializable
{
    public function __construct(
        protected ?string $id,
        protected DateTimeInterface $birthDate,
        protected string $email,
        protected string $gender,
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
        DomainException::assert(strlen($this->email), "Customer email required");
        DomainException::assert(in_array($this->gender, ['M', 'F']), "Customer gender is invalid");
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
        return [];
    }
}
