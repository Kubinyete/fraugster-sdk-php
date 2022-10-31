<?php

namespace Kubinyete\Fraugster\Http;

use JsonSerializable;
use Kubinyete\Fraugster\Exception\ParseException;
use Kubinyete\Fraugster\Util\ArrayUtil;

class Response implements JsonSerializable
{
    protected array $data;

    public function __construct(?string $body)
    {
        $this->data = $this->tryParse($body);
    }

    protected function tryParse(?string $body): array
    {
        $parsed = is_null($body) ? [] : json_decode($body, true);

        if (!is_array($parsed)) {
            throw new ParseException();
        }

        return $parsed;
    }

    public function get(string $path, mixed $default = null): mixed
    {
        return ArrayUtil::get($path, $this->data, $default);
    }

    public function jsonSerialize(): mixed
    {
        return $this->data;
    }
}
