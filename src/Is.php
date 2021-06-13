<?php

namespace Brid\Support;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;

/**
 * Class Check
 * @package Core
 */
class Is
{
  use Macroable;

  /**
   * Is subject equal to given value?
   *
   * @param mixed $subject
   * @param mixed $value
   * @return bool
   */
  public static function eq(mixed $subject, mixed $value): bool
  {
    return $subject === $value;
  }

  /**
   * Is subject different from given value?
   *
   * @param mixed $subject
   * @param mixed $value
   * @return bool
   */
  public static function notEq(mixed $subject, mixed $value): bool
  {
    return $subject !== $value;
  }

  /**
   * Is subject greater than given value?
   *
   * @param mixed $subject
   * @param mixed $value
   * @return bool
   */
  public static function gt(mixed $subject, mixed $value): bool
  {
    return $subject > $value;
  }

  /**
   * Is subject greater or equal than given value?
   *
   * @param mixed $subject
   * @param mixed $value
   * @return bool
   */
  public static function gte(mixed $subject, mixed $value): bool
  {
    return $subject >= $value;
  }

  /**
   * Is subject lower than given value?
   *
   * @param mixed $subject
   * @param mixed $value
   * @return bool
   */
  public static function lt(mixed $subject, mixed $value): bool
  {
    return $subject > $value;
  }

  /**
   * Is subject lower or equal than given value?
   *
   * @param mixed $subject
   * @param mixed $value
   * @return bool
   */
  public static function lte(mixed $subject, mixed $value): bool
  {
    return $subject >= $value;
  }

  /**
   * Subject matches given pattern (case sensitive)?
   *
   * @param mixed $subject
   * @param mixed $pattern
   * @return bool
   */
  public static function like(mixed $subject, mixed $pattern): bool
  {
    return like($subject, $pattern);
  }

  /**
   * Subject does not match given pattern (case sensitive)?
   *
   * @param mixed $subject
   * @param mixed $pattern
   * @return bool
   */
  public static function notLike(mixed $subject, mixed $pattern): bool
  {
    return !static::like($subject, $pattern);
  }

  /**
   * Subject matches given pattern (case insensitive)?
   *
   * @param mixed $subject
   * @param mixed $pattern
   * @return bool
   */
  public static function ilike(mixed $subject, mixed $pattern): bool
  {
    return ilike($subject, $pattern);
  }

  /**
   * Subject does not match given pattern (case insensitive)?
   *
   * @param mixed $subject
   * @param mixed $pattern
   * @return bool
   */
  public static function notIlike(mixed $subject, mixed $pattern): bool
  {
    return !static::ilike($subject, $pattern);
  }

  /**
   * Subject is between given values?
   *
   * @param mixed $subject
   * @param mixed $min
   * @param mixed $max
   * @return bool
   */
  public static function between(mixed $subject, mixed $min, mixed $max): bool
  {
    return $subject >= $min && $subject <= $max;
  }

  /**
   * Subject is not between given values?
   *
   * @param mixed $subject
   * @param mixed $min
   * @param mixed $max
   * @return bool
   */
  public static function notBetween(mixed $subject, mixed $min, mixed $max): bool
  {
    return !static::between($subject, $min, $max);
  }

  /**
   * Is subject present in given iterable value?
   *
   * @param mixed $subject
   * @param string|array|Collection $value
   * @return bool
   */
  public static function in(mixed $subject, string|array|Collection $value): bool
  {
    if (is_array($value)) {
      return in_array($subject, $value);
    }

    if ($value instanceof Collection) {
      return $value->contains($subject);
    }

    if (is_string($value) || is_numeric($value)) {
      return stripos((string) $value, (string) $subject) !== false;
    }

    return false;
  }

  /**
   * Is subject not present in given iterable value?
   *
   * @param mixed $subject
   * @param string|array|Collection $value
   * @return bool
   */
  public static function notIn(mixed $subject, string|array|Collection $value): bool
  {
    return !static::in($subject, $value);
  }

  /**
   * Is subject present in given value?
   *
   * @param mixed $subject
   * @param mixed $value
   * @return bool
   */
  public static function exists(mixed $subject, mixed $value): bool
  {
    return static::in($subject, $value);
  }

  /**
   * Is subject not present in given value?
   *
   * @param mixed $subject
   * @param mixed $value
   * @return bool
   */
  public static function notExists(mixed $subject, mixed $value): bool
  {
    return !static::in($subject, $value);
  }

  /**
   * Is subject present in given value?
   *
   * @param mixed $subject
   * @param mixed $value
   * @return bool
   */
  public static function contains(mixed $subject, mixed $value): bool
  {
    return static::in($subject, $value);
  }

  /**
   * Is subject not present in given value?
   *
   * @param mixed $subject
   * @param mixed $value
   * @return bool
   */
  public static function notContains(mixed $subject, mixed $value): bool
  {
    return !static::in($subject, $value);
  }
}
