<?php
namespace Register\Domain\Model\List;

use Register\Domain\Model\Host;

class HostList extends \ArrayIterator implements \JsonSerializable {
  public static function of(Host ... $values): HostList {
    return new HostList($values);
  }
  public function __construct(array $values) {
    parent::__construct($values);
  }
  public function current(): Host {
    return parent::current();
  }
  public function map(\Closure $clousure): HostList {
    return new HostList( array_map($clousure, iterator_to_array($this) ) );
  }
  public function jsonSerialize(): array {
    return iterator_to_array($this);
  }
}
