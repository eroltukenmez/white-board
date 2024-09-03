<?php

namespace App\Enums\Attributes;

use Illuminate\Support\Str;
use ReflectionClassConstant;


trait GetAttributes
{
    private static function getDescription(self $enum): string
    {
        $ref = new ReflectionClassConstant(self::class, $enum->name);
        $classAttributes = $ref->getAttributes(Description::class);

        if (count($classAttributes) === 0) {
            return Str::headline($enum->value);
        }

        return $classAttributes[0]->newInstance()->description;
    }

    /**
     * @param self $enum
     */
    public static function getTitle(self $enum): string
    {
        $ref = new ReflectionClassConstant(self::class, $enum->name);
        $classAttributes = $ref->getAttributes(Title::class);

        if (count($classAttributes) === 0) {
            return Str::headline($enum->value);
        }

        return __($classAttributes[0]->newInstance()->title);
    }

    /**
     * @return array<string,string>
     */
    public static function select(): array
    {
        /** @var array<object,string> $values */
        $values = collect(self::cases())
            ->map(function ($enum) {
                return (object)[
                    'title' => self::getTitle($enum),
                    'name' => $enum->name,
                    'value' => $enum->value,
                ];
            })->toArray();

        return $values;
    }

    /**
     * @return array<int>
     */
    public static function values(): array
    {
        /** @var array<int> $values */
        $values = collect(self::cases())
            ->map(function ($enum) {
                return $enum->value;
            })->toArray();

        return $values;
    }

}
