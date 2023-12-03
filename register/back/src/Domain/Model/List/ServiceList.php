<?php
namespace Register\Domain\Model\List;

use Register\Domain\Model\Service;

class ServiceList extends \ArrayIterator implements \JsonSerializable {
  public static function of(Service ... $values): ServiceList {
    return new ServiceList($values);
  }
  public function __construct(array $values) {
    parent::__construct($values);
  }
  public function current(): Service {
    return parent::current();
  }
  public function map(\Closure $clousure): ServiceList {
    return new ServiceList( array_map($clousure, iterator_to_array($this) ) );
  }
  public function jsonSerialize(): array {
    return iterator_to_array($this);
  }
}
