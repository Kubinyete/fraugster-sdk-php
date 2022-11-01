<?php

namespace Kubinyete\Fraugster\Util;

use Normalizer;

abstract class StringUtil
{
    public static function normalize(?string $value): string
    {
        $normalizedCharset = Normalizer::normalize(trim($value) ?? '', Normalizer::NFKD);
        $normalizedCharset = mb_str_split($normalizedCharset);
        $normalizedCharset = implode('', array_map(fn ($x) => ($o = mb_ord($x)) < 0x300 || $o > 0x362 ? $x : '', $normalizedCharset));
        return $normalizedCharset;
    }

    public static function normalizeUpper(?string $value): string
    {
        return strtoupper(self::normalize($value));
    }

    public static function normalizeLower(?string $value): string
    {
        return strtolower(self::normalize($value));
    }
}
