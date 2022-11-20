<?php

namespace azaian\enum;

use Exception;

trait EnumHelperTrait
{

    public function __invoke(): mixed
    {
        return $this->value ?? $this->name;
    }

    /**
     * @throws Exception
     */
    public static function __callStatic($name, $args)
    {

        foreach (static::cases() as $case) if ($case->name == $name) return $case->value ?? $case->name;

        throw new Exception('undefined enum case ' . self::class_basename(static::class) . "::" . $name, '422');
    }

    public static function names(): array
    {
        return array_column(static::cases(), 'name');
    }

    public static function values(): array
    {
        $cases = static::cases();

        return isset($cases[0]) && isset($cases[0]->value)
            ? array_column($cases, 'value')
            : array_column($cases, 'name');
    }

    public static function options(): array
    {
        $cases = static::cases();

        return isset($cases[0]) && isset($cases[0]->value)
            ? array_column($cases, 'value', 'name')
            : array_column($cases, 'name');
    }

    public static function hasValue($value): bool
    {
        $cases = array_column(static::cases(), 'value');
        return in_array($value, $cases);
    }

    private static function class_basename($class)
    {
        $class = is_object($class) ? get_class($class) : $class;

        return basename(str_replace('\\', '/', $class));
    }
}
