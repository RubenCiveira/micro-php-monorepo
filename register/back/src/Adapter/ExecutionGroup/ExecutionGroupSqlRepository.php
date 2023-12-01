<?php
namespace Register\Adapter\ExecutionGroup;

use Closure;
use Civi\Micro\Sql\SqlTemplate;
use Civi\Micro\Sql\SqlParam;
use Register\Domain\Port\Spi\ExecutionGroup\ExecutionGroupRepository;
use Register\Domain\Model\ExecutionGroup;
use Register\Domain\Model\Query\ExecutionGroupFilter;
use Register\Domain\Model\Query\ExecutionGroupSort;
use Register\Domain\Model\Ref\ExecutionGroupRef;
use Civi\Micro\Exception\OptimistLockException;
use Civi\Micro\Exception\NotFoundException;
use Civi\Micro\Sql\NotUniqueException;
use Civi\Micro\Exception\ConstraintException;


class ExecutionGroupSqlRepository implements ExecutionGroupRepository {
  public function __construct(private readonly SqlTemplate $db) {}
  public function list(?ExecutionGroupFilter $filter, ?ExecutionGroupSort $sort): array {
    $sqlFilter = $this->filter(null, $filter, $sort);
    return $this->db->query($sqlFilter['query'], $sqlFilter['params'], fn($row) => $this->mapper($row) );
  }
  public function create(ExecutionGroup $entity): ExecutionGroup {
    try {
      $this->db->execute('INSERT INTO execution_group ( uid, name, version) VALUES ( :uid, :name, :version)',[
           new SqlParam(name: 'uid', value: $entity->uid, type: SqlParam::INT),
           new SqlParam(name: 'name', value: $entity->name, type: SqlParam::STR),
           new SqlParam(name: 'version', value: 0, type: SqlParam::INT)
      ]);
    } catch(NotUniqueException $ex) {
      $this->checkDuplicates( $entity );
    }
    return $entity->toBuilder()->version( 0 )->build();
  }
  public function retrieve(ExecutionGroupRef $ref, ?ExecutionGroupFilter $filter=null): ?ExecutionGroup {
    $sqlFilter = $this->filter($ref, $filter, null);
    return $this->db->findOne($sqlFilter['query'], $sqlFilter['params'], fn($row) => $this->mapper($row));
  }
  public function update(ExecutionGroup $update): ?ExecutionGroup {
    try {
      $result = $this->db->execute('UPDATE execution_group SET name = :name , version = :version WHERE uid = :uid and version = :_lock_version', [
           new SqlParam(name: 'uid', value: $update->uid, type: SqlParam::INT),
           new SqlParam(name: 'name', value: $update->name, type: SqlParam::STR),
           new SqlParam(name: 'version', value: $update->version + 1, type: SqlParam::INT),
           new SqlParam(name: '_lock_version', value: $update->version, type: SqlParam::INT)
      ]);
      if( !$result && $this->db->exists('select uid from execution_group where uid = :uid', ['uid' => $update->uid ]) ) {
        throw new OptimistLockException($update->uid, $update->version);
      } else if(!$result) {
        throw new NotFoundException($update->uid);
      }
    } catch(NotUniqueException $ex) {
      $this->checkDuplicates( $entity );
    }
    return $update->toBuilder()->version( $update->version + 1 )->build();
  }
  public function delete(ExecutionGroupRef $ref): bool {
    return $this->db->execute('DELETE FROM execution_group where uid = :uid',['uid' => $entity->uid]);
  }
  public function exists(ExecutionGroupRef $ref, ?ExecutionGroupFilter $filter=null): bool {
    $sqlFilter = $this->filter($ref, $filter, null);
    return $this->db->exists($sqlFilter['query'], $sqlFilter['params']);
  }
  private function filter(?ExecutionGroupRef $ref,?ExecutionGroupFilter $filter,?ExecutionGroupSort $sort) {
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
    return ['query' => 'SELECT * FROM execution_group'
                          . ($join ? ' JOIN ' . substr($join, 6) : '')
                          . ($query ? ' WHERE ' . substr($query, 4) : ''),
                 'params' => $params];
  }
  private function checkDuplicates(ExecutionGroup $entity) {
    $values = ['uid' => $entity->uid];
    if( $this->db->exists('SELECT  uid from execution_group where uid = :uid', $values) ) {
      throw new ConstraintException('not-unique', $values);
    }
    $values = ['name' => $entity->name];
    if( $this->db->exists('SELECT  name from execution_group where name = :name and uid != :uid', $values) ) {
      throw new ConstraintException('not-unique', ['name' => $entity->name]);
    }
  }
  private function mapper($row): ExecutionGroup{
    return ExecutionGroup::builder()->uid($row['uid'])
           ->name($row['name'])
           ->version($row['version'])->build();
  }
}

