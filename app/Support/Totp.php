<?php

declare(strict_types=1);

namespace App\Support;

use InvalidArgumentException;
use RuntimeException;

final class Totp
{
    public static function secret(): string
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $secret = '';
        for ($i = 0; $i < 32; $i++) {
            $secret .= $alphabet[random_int(0, 31)];
        }

        return $secret;
    }

    public static function code(string $secret, int $step): string
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $bits = '';
        foreach (str_split($secret) as $char) {
            $position = strpos($alphabet, $char);
            throw_if($position === false, InvalidArgumentException::class, 'Chave TOTP inválida.');
            $bits .= str_pad(decbin($position), 5, '0', STR_PAD_LEFT);
        }
        $key = '';
        foreach (str_split($bits, 8) as $byte) {
            if (strlen($byte) === 8) {
                $key .= chr((int) bindec($byte));
            }
        }
        $hash = hash_hmac('sha1', pack('N2', 0, $step), $key, true);
        $offset = ord($hash[19]) & 15;
        $unpacked = unpack('N', substr($hash, $offset, 4));
        throw_if($unpacked === false, RuntimeException::class, 'Falha ao calcular código.');
        $number = $unpacked[1] & 0x7FFFFFFF;

        return str_pad((string) ($number % 1000000), 6, '0', STR_PAD_LEFT);
    }

    public static function verify(string $secret, string $code, int $lastStep = -1): ?int
    {
        if (! preg_match('/^\d{6}$/', $code)) {
            return null;
        }
        $current = intdiv(time(), 30);
        foreach ([$current - 1, $current, $current + 1] as $step) {
            if ($step > $lastStep && hash_equals(self::code($secret, $step), $code)) {
                return $step;
            }
        }

        return null;
    }
}
