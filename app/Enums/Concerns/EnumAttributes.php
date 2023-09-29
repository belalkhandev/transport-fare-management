<?php

namespace App\Enums\Concerns;

use App\Enums\Attributes\Description;
use Illuminate\Support\Str;
use ReflectionClassConstant;

trait EnumAttributes
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

    public static function casesArray(): array
    {
        return array_combine(self::names(), self::values());
    }

    public static function descriptionArray(): array
    {
        return collect(self::cases())
            ->map(function ($enum) {
                return [
                    'name' => $enum->name,
                    'name_description' => self::getDescription($enum),
                    'value' => $enum->value,
                ];
            })->toArray();
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function descriptions(): array
    {
        return collect(self::cases())
            ->map(function ($enum) {
                return [
                    'description' => self::getDescription($enum),
                ];
            })->pluck('description')->toArray();
    }
}
