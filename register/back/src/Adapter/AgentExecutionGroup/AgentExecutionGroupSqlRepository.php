<?php
namespace Register\Adapter\AgentExecutionGroup;

use Closure;
use Civi\Micro\Sql\SqlTemplate;
use Civi\Micro\Sql\SqlParam;
use Register\Domain\Port\Spi\AgentExecutionGroup\AgentExecutionGroupRepository;
use Register\Domain\Model\AgentExecutionGroup;
use Register\Domain\Model\Query\AgentExecutionGroupFilter;
use Register\Domain\Model\Query\AgentExecutionGroupSort;
use Register\Domain\Model\Ref\AgentExecutionGroupRef;
use Civi\Micro\Exception\OptimistLockException;
use Civi\Micro\Exception\NotFoundException;
use Civi\Micro\Sql\NotUniqueException;
use Civi\Micro\Exception\ConstraintException;
use Register\Domain\Model\Ref\AgentRef;
use Register\Domain\Model\Ref\ExecutionGroupRef;


class AgentExecutionGroupSqlRepository implements AgentExecutionGroupRepository {
  public function __construct(private readonly SqlTemplate $db) {}
  public function list(?AgentExecutionGroupFilter $filter, ?AgentExecutionGroupSort $sort): array {
    $sqlFilter = $this->filter(null, $filter, $sort);
    return $this->db->query($sqlFilter['query'], $sqlFilter['params'], fn($row) => $this->mapper($row) );
  }
  public function create(AgentExecutionGroup $entity): AgentExecutionGroup {
    try {
      $this->db->execute('INSERT INTO agent_execution_group ( uid, agent, group, version) VALUES ( :uid, :agent, :group, :version)',[
           new SqlParam(name: 'uid', value: $entity->uid, type: SqlParam::INT),
           new SqlParam(name: 'agent', value: $entity->agent?->uid, type: SqlParam::STR),
           new SqlParam(name: 'group', value: $entity->group?->uid, type: SqlParam::STR),
           new SqlParam(name: 'version', value: 0, type: SqlParam::INT)
      ]);
    } catch(NotUniqueException $ex) {
      $this->checkDuplicates( $entity );
    }
    return $entity->toBuilder()->version( 0 )->build();
  }
  public function retrieve(AgentExecutionGroupRef $ref, ?AgentExecutionGroupFilter $filter=null): ?AgentExecutionGroup {
    $sqlFilter = $this->filter($ref, $filter, null);
    return $this->db->findOne($sqlFilter['query'], $sqlFilter['params'], fn($row) => $this->mapper($row));
  }
  public function update(AgentExecutionGroup $update): ?AgentExecutionGroup {
    try {
      $result = $this->db->execute('UPDATE agent_execution_group SET agent = :agent , group = :group , version = :version WHERE uid = :uid and version = :_lock_version', [
           new SqlParam(name: 'uid', value: $update->uid, type: SqlParam::INT),
           new SqlParam(name: 'agent', value: $update->agent?->uid, type: SqlParam::INT),
           new SqlParam(name: 'group', value: $update->group?->uid, type: SqlParam::INT),
           new SqlParam(name: 'version', value: $update->version + 1, type: SqlParam::INT),
           new SqlParam(name: '_lock_version', value: $update->version, type: SqlParam::INT)
      ]);
      if( !$result && $this->db->exists('select uid from agent_execution_group where uid = :uid', ['uid' => $update->uid ]) ) {
        throw new OptimistLockException($update->uid, $update->version);
      } else if(!$result) {
        throw new NotFoundException($update->uid);
      }
    } catch(NotUniqueException $ex) {
      $this->checkDuplicates( $entity );
    }
    return $update->toBuilder()->version( $update->version + 1 )->build();
  }
  public function delete(AgentExecutionGroupRef $ref): bool {
    return $this->db->execute('DELETE FROM agent_execution_group where uid = :uid',['uid' => $entity->uid]);
  }
  public function exists(AgentExecutionGroupRef $ref, ?AgentExecutionGroupFilter $filter=null): bool {
    $sqlFilter = $this->filter($ref, $filter, null);
    return $this->db->exists($sqlFilter['query'], $sqlFilter['params']);
  }
  private function filter(?AgentExecutionGroupRef $ref,?AgentExecutionGroupFilter $filter,?AgentExecutionGroupSort $sort) {
    $join = '';
    $query = '';
    $params = [];
    if( $ref && $ref->uid ) {
      $query .= ' and uid = :uid';
      $params[] = new SqlParam( name: 'uid', value: $ref->uid, type: SqlParam::INT);
    }
    if( $filter ) {
      if( $filter->group) {
        $query .= ' and group = :group';
        $params[] = new SqlParam(name: 'group', value: $filter->group, type: SqlParam::STR);
      }
    }
    return ['query' => 'SELECT * FROM agent_execution_group'
                          . ($join ? ' JOIN ' . substr($join, 6) : '')
                          . ($query ? ' WHERE ' . substr($query, 4) : ''),
                 'params' => $params];
  }
  private function checkDuplicates(AgentExecutionGroup $entity) {
    $values = ['uid' => $entity->uid];
    if( $this->db->exists('SELECT  uid from agent_execution_group where uid = :uid', $values) ) {
      throw new ConstraintException('not-unique', $values);
    }
  }
  private function mapper($row): AgentExecutionGroup{
    return AgentExecutionGroup::builder()->uid($row['uid'])
           ->agent(new AgentRef(uid: $row['agent']))
           ->group(new ExecutionGroupRef(uid: $row['group']))
           ->version($row['version'])->build();
  }
}

