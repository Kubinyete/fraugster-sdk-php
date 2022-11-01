<?php

namespace Kubinyete\Fraugster\Model;

use JsonSerializable;
use Kubinyete\Fraugster\Model\Exception\DomainException;
use Throwable;

class DeviceInfo implements JsonSerializable
{
    public function __construct(
        protected ?string $user_agent,
        protected ?bool $cookies_enabled,
        protected ?bool $java_enabled,
        protected ?string $language,
        protected ?string $plugins,
        protected ?string $timezone,
        protected ?int $timezone_offset,
        protected ?bool $do_not_track,
        protected ?string $platform,
        protected ?bool $geo_supported,
        protected ?int $screen_width,
        protected ?int $screen_height,
        protected ?int $screen_depth,
        protected ?int $logical_cores,
    ) {
    }

    //

    public function getUserAgent(): ?string
    {
        return $this->user_agent;
    }

    public function getCookiesEnabled(): ?bool
    {
        return $this->cookies_enabled;
    }

    public function getJavaEnabled(): ?bool
    {
        return $this->java_enabled;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function getPlugins(): ?string
    {
        return $this->plugins;
    }

    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    public function getTimezoneOffset(): ?int
    {
        return $this->timezone_offset;
    }

    public function getDoNotTrack(): ?bool
    {
        return $this->do_not_track;
    }

    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    public function getGeoSupported(): ?bool
    {
        return $this->geo_supported;
    }

    public function getScreenWidth(): ?int
    {
        return $this->screen_width;
    }

    public function getScreenHeight(): ?int
    {
        return $this->screen_height;
    }

    public function getScreenDepth(): ?int
    {
        return $this->screen_depth;
    }

    public function getLogicalCores(): ?int
    {
        return $this->logical_cores;
    }

    //

    public static function tryParse(string $json): ?self
    {
        $decoded = json_decode($json, true);

        try {
            return new self(...$decoded);
        } catch (Throwable $e) {
        }

        return null;
    }

    public static function parse(string $json): self
    {
        $parsed = self::tryParse($json);
        DomainException::assert($parsed, "Failed to parse device info from json body");
        return $parsed;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}
