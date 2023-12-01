<?php
namespace Register\Adapter\Agent;

use Closure;
use Civi\Micro\Sql\SqlTemplate;
use Civi\Micro\Sql\SqlParam;
use Register\Domain\Port\Spi\Agent\AgentRepository;
use Register\Domain\Model\Agent;
use Register\Domain\Model\Query\AgentFilter;
use Register\Domain\Model\Query\AgentSort;
use Register\Domain\Model\Ref\AgentRef;
use Civi\Micro\Exception\OptimistLockException;
use Civi\Micro\Exception\NotFoundException;
use Civi\Micro\Sql\NotUniqueException;
use Civi\Micro\Exception\ConstraintException;


class AgentSqlRepository implements AgentRepository {
  public function __construct(private readonly SqlTemplate $db) {}
  public function list(?AgentFilter $filter, ?AgentSort $sort): array {
    $sqlFilter = $this->filter(null, $filter, $sort);
    return $this->db->query($sqlFilter['query'], $sqlFilter['params'], fn($row) => $this->mapper($row) );
  }
  public function create(Agent $entity): Agent {
    try {
      $this->db->execute('INSERT INTO agent ( uid, name, groups, version) VALUES ( :uid, :name, :groups, :version)',[
           new SqlParam(name: 'uid', value: $entity->uid, type: SqlParam::INT),
           new SqlParam(name: 'name', value: $entity->name, type: SqlParam::STR),
           new SqlParam(name: 'groups', value: $entity->groups?->uid, type: SqlParam::STR),
           new SqlParam(name: 'version', value: 0, type: SqlParam::INT)
      ]);
    } catch(NotUniqueException $ex) {
      $this->checkDuplicates( $entity );
    }
    return $entity->toBuilder()->version( 0 )->build();
  }
  public function retrieve(AgentRef $ref, ?AgentFilter $filter=null): ?Agent {
    $sqlFilter = $this->filter($ref, $filter, null);
    return $this->db->findOne($sqlFilter['query'], $sqlFilter['params'], fn($row) => $this->mapper($row));
  }
  public function update(Agent $update): ?Agent {
    try {
      $result = $this->db->execute('UPDATE agent SET name = :name , groups = :groups , version = :version WHERE uid = :uid and version = :_lock_version', [
           new SqlParam(name: 'uid', value: $update->uid, type: SqlParam::INT),
           new SqlParam(name: 'name', value: $update->name, type: SqlParam::STR),
           new SqlParam(name: 'version', value: $update->version + 1, type: SqlParam::INT),
           new SqlParam(name: '_lock_version', value: $update->version, type: SqlParam::INT)
      ]);
      if( !$result && $this->db->exists('select uid from agent where uid = :uid', ['uid' => $update->uid ]) ) {
        throw new OptimistLockException($update->uid, $update->version);
      } else if(!$result) {
        throw new NotFoundException($update->uid);
      }
    } catch(NotUniqueException $ex) {
      $this->checkDuplicates( $entity );
    }
    return $update->toBuilder()->version( $update->version + 1 )->build();
  }
  public function delete(AgentRef $ref): bool {
    return $this->db->execute('DELETE FROM agent where uid = :uid',['uid' => $entity->uid]);
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
      $query .= ' and uid = :uid';
      $params[] = new SqlParam( name: 'uid', value: $ref->uid, type: SqlParam::INT);
    }
    if( $filter ) {
      if( $filter->search) {
        $query .= ' and ( name like :search)';
        $params[] = new SqlParam(name:'search', value: '%'. $filter->search . '%', type: SqlType::STR);
      }
    }
    return ['query' => 'SELECT * FROM agent'
                          . ($join ? ' JOIN ' . substr($join, 6) : '')
                          . ($query ? ' WHERE ' . substr($query, 4) : ''),
                 'params' => $params];
  }
  private function checkDuplicates(Agent $entity) {
    $values = ['uid' => $entity->uid];
    if( $this->db->exists('SELECT  uid from agent where uid = :uid', $values) ) {
      throw new ConstraintException('not-unique', $values);
    }
    $values = ['name' => $entity->name];
    if( $this->db->exists('SELECT  name from agent where name = :name and uid != :uid', $values) ) {
      throw new ConstraintException('not-unique', ['name' => $entity->name]);
    }
  }
  private function mapper($row): Agent{
    return Agent::builder()->uid($row['uid'])
           ->name($row['name'])
           ->version($row['version'])->build();
  }
}

