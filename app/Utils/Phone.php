<?php

namespace App\Utils;

use Illuminate\Support\Str;


class Phone
{
    protected $phone;
    protected $phone_without_prefix;

    public function __construct(?string $phone)
    {
        $phone = preg_replace('/[^0-9]+/', '', $phone);

        if (strlen($phone) === 9) {
            $this->phone_without_prefix = preg_replace('/[^0-9]+/', '', $phone);
            $this->phone                = '998' . preg_replace('/[^0-9]+/', '', $phone);
        } elseif (strlen($phone) === 12 || (str_starts_with($phone, '+') && strlen($phone) === 13)) {
            $this->phone                = preg_replace('/[^0-9]+/', '', $phone);
            $this->phone_without_prefix = substr($this->phone, 3);
        }
    }

    public function validate(): bool
    {
        $phone = $this->getFull();

        return !(strlen($phone) !== 12 || Str::startsWith($phone, '998') === false);
    }

    public function getFull(bool $return_as_string = true): string|int|null
    {
        return $return_as_string ? $this->phone : (int)$this->phone;
    }

    public function getShort(bool $return_as_string = true): string|int
    {
        return $return_as_string ? $this->phone_without_prefix : (int)$this->phone_without_prefix;
    }

    public function getMasked(): string
    {
        $res = "";
        if ($this->phone) {
            $res = $this->phone;
            for ($i = 6; $i < 10; $i++) {
                $res = substr_replace($res, "*", $i, 1);
            }
        }

        return $res;
    }

    public function getFormatted(bool $full = false): string
    {
        $pieces = str_split($this->phone);

        $res = "";
        if ($full) {
            $res .= implode("", array_slice($pieces, 0, 3)) . " ";
        }
        $res .= implode("", array_slice($pieces, 3, 2)) . " ";
        $res .= implode("", array_slice($pieces, 5, 3)) . " ";
        $res .= implode("", array_slice($pieces, 8, 2)) . " ";
        $res .= implode("", array_slice($pieces, 10, 2)) . " ";

        return $res;
    }

    public static function parseFull(?string $phone): string|null
    {
        $phone = preg_replace('/[^0-9]+/', '', $phone);

        return match (strlen($phone)) {
            12      => $phone,
            9       => "998" . $phone,
            default => null,
        };
    }
    public static function parse(?string $phone): string|null
    {
        return preg_replace('/[^0-9]+/', '', $phone);
    }

    public function toString(): string
    {
        return $this->phone;
    }

    // make number like +998(99)-999-99-99
    public function format(?bool $withCode = true, ?bool $withoutBrackets = false, string $middleMarks = ' ')
    {
        $pieces = str_split($this->phone);

        $res = "";

        if ($this->phone === null) {
            return;
        }

        if ($withCode) {
            $res .= '+' . implode("", array_slice($pieces, 0, 3));
        }

        if ($withoutBrackets) {
            $res .= implode("", array_slice($pieces, 3, 2)) . $middleMarks;
        }else{
            $res .= "(" . implode("", array_slice($pieces, 3, 2)) . ")" . $middleMarks;
        }
        $res .= implode("", array_slice($pieces, 5, 3)) . $middleMarks;
        $res .= implode("", array_slice($pieces, 8, 2)) . $middleMarks;
        $res .= implode("", array_slice($pieces, 10, 2));

        return $res;
    }
}
