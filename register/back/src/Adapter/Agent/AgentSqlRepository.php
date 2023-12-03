<?php
namespace Register\Adapter\Agent;

use Civi\Micro\Exception\ConstraintException;
use Civi\Micro\Exception\NotFoundException;
use Civi\Micro\Exception\OptimistLockException;
use Civi\Micro\Sql\NotUniqueException;
use Civi\Micro\Sql\SqlParam;
use Civi\Micro\Sql\SqlTemplate;
use Closure;
use Register\Domain\Model\Agent;
use Register\Domain\Model\AgentExecutionGroup;
use Register\Domain\Model\List\AgentExecutionGroupList;
use Register\Domain\Model\List\AgentList;
use Register\Domain\Model\Query\AgentFilter;
use Register\Domain\Model\Query\AgentSort;
use Register\Domain\Model\Ref\AgentRef;
use Register\Domain\Model\Ref\ExecutionGroupRef;
use Register\Domain\Port\Spi\AgentExecutionGroup\AgentExecutionGroupRepository;
use Register\Domain\Port\Spi\Agent\AgentRepository;
class AgentSqlRepository implements AgentRepository {
  public function __construct(private readonly SqlTemplate $db, private readonly AgentExecutionGroupRepository $agentExecutionGroupRepository) {}
  private function mapperGroups($row): AgentExecutionGroup{
    return AgentExecutionGroup::builder()->uid($row['uid'])
           ->agent(new AgentRef(uid: $row['agent']))
           ->group(new ExecutionGroupRef(uid: $row['group']))
           ->version($row['version'])->build();
  }
  public function list(?AgentFilter $filter, ?AgentSort $sort): AgentList {
    $sqlFilter = $this->filter(null, $filter, $sort);
    $result = new AgentList( $this->db->query($sqlFilter['query'], $sqlFilter['params'], fn($row) => $this->mapper($row) ) );
    $ids = [];
    foreach($result as $entity) {
      $uids[] = $entity->uid;
    }
    $childsGroups= $this->db->query('select * from "agent_execution_group" where "agent" IN (:groups)', [
        new SqlParam(name: 'groups', value: $uids, type: SqlParam::STR)
    ], fn($row) => $this->mapperGroups($row) );
    $assignedChildsGroups = [];
    foreach($childsGroups as $child) {
      $parent = $child->agent->uid;
      if( !isset($assignedChildsGroups[$parent]) ) {
        $assignedChildsGroups[$parent] = [];
      }
      $assignedChildsGroups[$parent][] = $child;
    }
    $filled = [];
    foreach($result as $row) {
      $filled[] = $row->toBuilder()->groups(new AgentExecutionGroupList(isset($assignedChildsGroups[$row->uid])?$assignedChildsGroups[$row->uid]:[]))->build();
    }
    return new AgentList( $filled );
  }
  public function create(Agent $entity): Agent {
    $this->db->begin();
    try {
      $this->db->execute('INSERT INTO "agent" ( "uid", "name", "version") VALUES ( :uid, :name, :version)',[
           new SqlParam(name: 'uid', value: $entity->uid, type: SqlParam::INT),
           new SqlParam(name: 'name', value: $entity->name, type: SqlParam::STR),
           new SqlParam(name: 'version', value: 0, type: SqlParam::INT)
      ]);
      $this->saveChilds($entity);
      $this->db->commit();
    } catch(NotUniqueException $ex) {
      $this->db->rollback();
      $this->checkDuplicates( $entity );
    }
    return $entity->toBuilder()->version( 0 )->build();
  }
  public function retrieve(AgentRef $ref, ?AgentFilter $filter=null): ?Agent {
    $sqlFilter = $this->filter($ref, $filter, null);
    $result = $this->db->findOne($sqlFilter['query'], $sqlFilter['params'], fn($row) => $this->mapper($row));
    $childsGroups= $this->db->query('select * from "agent_execution_group" where "agent" = (:agent)', [
        new SqlParam(name: 'agent', value: $result->uid, type: SqlParam::STR)
    ], fn($row) => $this->mapperGroups($row) );
      return $result->toBuilder()->groups(new AgentExecutionGroupList($childsGroups))->build();
  }
  public function update(Agent $update): ?Agent {
    try {
    $this->db->begin();
      $result = $this->db->execute('UPDATE "agent" SET "name" = :name , "version" = :version WHERE "uid" = :uid and "version" = :_lock_version', [
           new SqlParam(name: 'uid', value: $update->uid, type: SqlParam::INT),
           new SqlParam(name: 'name', value: $update->name, type: SqlParam::STR),
           new SqlParam(name: 'version', value: $update->version + 1, type: SqlParam::INT),
           new SqlParam(name: '_lock_version', value: $update->version, type: SqlParam::INT)
      ]);
      if( !$result && $this->db->exists('select "uid" from "agent" where "uid" = :uid', ['uid' => $update->uid ]) ) {
        throw new OptimistLockException($update->uid, $update->version);
      } else if(!$result) {
        throw new NotFoundException($update->uid);
      }
      $this->saveChilds($entity);
      $this->db->commit();
    } catch(NotUniqueException $ex) {
      $this->db->rollback();
      $this->checkDuplicates( $entity );
    }
    return $update->toBuilder()->version( $update->version + 1 )->build();
  }
  public function delete(AgentRef $ref): bool {
  $this->db->begin();
  try {
$this->db->execute('DELETE FROM "agent_execution_group" where "agent" = :parent', [new SqlParam(name:'uid', value:$ref->uid, type:SqlParam::INT) ]);    $result = $this->db->execute('DELETE FROM "agent" where "uid" = :uid',[new SqlParam(name: 'uid', value: $ref->uid, type: SqlParam::INT)]);
    $this->db->commit();
    return $result;
  } catch(\Exception $ex) {
    $this->db->rollback();
    throw $ex;
  }
  }
  public function exists(AgentRef $ref, ?AgentFilter $filter=null): bool {
    $sqlFilter = $this->filter($ref, $filter, null);
    return $this->db->exists($sqlFilter['query'], $sqlFilter['params']);
  }
  private function filter(?AgentRef $ref,?AgentFilter $filter,?AgentSort $sort) {
    $join = '';
    $query = '';
    $params = [];
    if( $ref && $ref->uid ) {
      $query .= ' and "uid" = :uid';
      $params[] = new SqlParam( name: 'uid', value: $ref->uid, type: SqlParam::INT);
    }
    if( $filter ) {
      if( $filter->uids ) {
        $query .= ' and "uid" in (:uids)';
        $params[] = new SqlParam(name:'uids', value: $filter->uids, type: SqlParam::INT );
      }
      if( $filter->search) {
        $query .= ' and ( "name" like :search)';
        $params[] = new SqlParam(name:'search', value: '%'. $filter->search . '%', type: SqlType::STR);
      }
    }
    return ['query' => 'SELECT * FROM "agent"'
                          . ($join ? ' JOIN ' . substr($join, 6) : '')
                          . ($query ? ' WHERE ' . substr($query, 4) : ''),
                 'params' => $params];
  }
  private function checkDuplicates(Agent $entity) {
    $values = ['uid' => $entity->uid];
    if( $this->db->exists('SELECT  "uid" from "agent" where "uid" = :uid', $values) ) {
      throw new ConstraintException('not-unique', $values);
    }
    $values = ['name' => $entity->name, 'uid' => $entity->uid];
    if( $this->db->exists('SELECT  "name" from "agent" where "name" = :name and "uid" != :uid', $values) ) {
      throw new ConstraintException('not-unique', ['name' => $entity->name]);
    }
  }
  private function mapper($row): Agent{
    return Agent::builder()->uid($row['uid'])
           ->name($row['name'])
           ->version($row['version'])->build();
  }
  private function saveChilds(Agent $parent) {
    if( $parent->groups ) {
      foreach($parent->groups as $child) {
        $toSave = $child->toBuilder()->agent(new AgentRef($parent->uid))->build();
        if( $this->agentExecutionGroupRepository->exists($child) ) {
          $this->agentExecutionGroupRepository->update($child);
        } else {
          $this->agentExecutionGroupRepository->create($child);
        }
      }
    }
  }
}

