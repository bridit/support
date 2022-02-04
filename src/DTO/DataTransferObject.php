<?php

namespace Brid\Support\DTO;

use Brid\Support\DTO\Attributes\CamelCaseAdapter;
use Brid\Support\DTO\Attributes\SnakeCaseAdapter;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use ReflectionClass;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class DataTransferObject extends \Spatie\DataTransferObject\DataTransferObject
{

  /**
   * @throws UnknownProperties
   */
  public function __construct(...$args)
  {
    parent::__construct($this->getArgs($args));
  }

  private function getArgs(array $args): array
  {
    if (is_array($args[0] ?? null)) {
      $args = $args[0];
    }

    $reflectionClass = new ReflectionClass($this);
    $camelCaseAdapter = !blank($reflectionClass->getAttributes(CamelCaseAdapter::class));
    $snakeCaseAdapter = !blank($reflectionClass->getAttributes(SnakeCaseAdapter::class));

    if ($camelCaseAdapter) {
      $args = array_convert_key_case($args, 'camel', false);
    }

    if ($snakeCaseAdapter) {
      $args = array_convert_key_case($args, 'snake', false);
    }

    return $args;
  }

  /**
   * @param array $params
   * @return static
   * @throws UnknownProperties
   */
  public static function fromArray(array $params): self
  {
    return new static($params);
  }

  /**
   * @param Collection $collection
   * @return static
   * @throws UnknownProperties
   */
  public static function fromCollection(Collection $collection): self
  {
    return new static($collection->toArray());
  }

  /**
   * @param string $json
   * @return static
   * @throws UnknownProperties
   */
  public static function fromJson(string $json): self
  {
    return new static(json_decode($json, true));
  }

  /**
   * Get the instance as an json string.
   *
   * @param string|null $case
   * @param bool $preserveEmpty
   * @return string
   */
  public function toJson(string $case = null, bool $preserveEmpty = true): string
  {
    return json_encode($this->getArray($case, $preserveEmpty));
  }

  public function getArray(string $case = null, bool $preserveEmpty = true): array
  {
    $values = array_map(function($item) {
      if ($item instanceof Arrayable) {
        return $item->toArray();
      }

      return $item;
    }, $this->toArray());

    $values = null === $case ? $values : array_convert_key_case($values, $case, true);

    return true === $preserveEmpty
      ? $values
      : array_filter($values, fn($item) => !blank($item));
  }

  /**
   * @return string
   */
  public function __toString()
  {
    return $this->toJson();
  }

}