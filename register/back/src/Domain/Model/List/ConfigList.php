<?php
namespace Register\Domain\Model\List;

use Register\Domain\Model\Config;

class ConfigList extends \ArrayIterator implements \JsonSerializable {
  public static function of(Config ... $values): ConfigList {
    return new ConfigList($values);
  }
  public function __construct(array $values) {
    parent::__construct($values);
  }
  public function current(): Config {
    return parent::current();
  }
  public function map(\Closure $clousure): ConfigList {
    return new ConfigList( array_map($clousure, iterator_to_array($this) ) );
  }
  public function jsonSerialize(): array {
    return iterator_to_array($this);
  }
}
