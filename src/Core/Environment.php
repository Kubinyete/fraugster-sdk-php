<?php

namespace Kubinyete\Fraugster\Core;

class Environment
{
    private const STAGING = 'https://api-perf.fraugsterapi.com';
    private const PRODUCTION = 'https://api.fraugsterapi.com';

    protected string $url;

    protected function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    //

    public static function staging(): self
    {
        return new self(self::STAGING);
    }

    public static function production(): self
    {
        return new self(self::PRODUCTION);
    }
}
