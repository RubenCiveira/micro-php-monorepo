<?php
namespace Register\Domain\Model\List;

use Register\Domain\Model\ExecutionGroup;

class ExecutionGroupList extends \ArrayIterator implements \JsonSerializable {
  public static function of(ExecutionGroup ... $values): ExecutionGroupList {
    return new ExecutionGroupList($values);
  }
  public function __construct(array $values) {
    parent::__construct($values);
  }
  public function current(): ExecutionGroup {
    return parent::current();
  }
  public function map(\Closure $clousure): ExecutionGroupList {
    return new ExecutionGroupList( array_map($clousure, iterator_to_array($this) ) );
  }
  public function jsonSerialize(): array {
    return iterator_to_array($this);
  }
}
