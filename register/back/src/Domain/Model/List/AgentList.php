<?php
namespace Register\Domain\Model\List;

use Register\Domain\Model\Agent;

class AgentList extends \ArrayIterator {
  public static function of(Agent ... $values): AgentList {
    return new AgentList($values);
  }
  public function __construct(array $values) {
    parent::__construct($values);
  }
  public function current(): Agent {
    return parent::current();
  }
  public function map(\Closure $clousure): AgentList {
    return new AgentList( array_map($clousure, iterator_to_array($this) ) );
  }
  public function toArray(): array {
    return iterator_to_array($this);
  }
}
