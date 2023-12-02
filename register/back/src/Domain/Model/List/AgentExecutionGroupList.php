<?php
namespace Register\Domain\Model\List;

use Register\Domain\Model\AgentExecutionGroup;

class AgentExecutionGroupList extends \ArrayIterator {
  public static function of(AgentExecutionGroup ... $values): AgentExecutionGroupList {
    return new AgentExecutionGroupList($values);
  }
  public function __construct(array $values) {
    parent::__construct($values);
  }
  public function current(): AgentExecutionGroup {
    return parent::current();
  }
  public function map(\Closure $clousure): AgentExecutionGroupList {
    return new AgentExecutionGroupList( array_map($clousure, iterator_to_array($this) ) );
  }
  public function toArray(): array {
    return iterator_to_array($this);
  }
}
