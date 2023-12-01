<?php

use PHPUnit\Framework\TestCase;
use Civi\Micro\Sql\SqlTemplate;
use Register\Adapter\ExecutionGroup\ExecutionGroupSqlRepository;
use Register\Domain\Model\ExecutionGroup;
use Register\Domain\Model\Ref\ExecutionGroup\ExecutionGroupRef;
use Register\Domain\Model\Query\ExecutionGroup\ExecutionGroupFilter;
use Register\Domain\Model\Query\ExecutionGroup\ExecutionGroupSort;

final class ExecutionGroupSqlRepositoryTest extends TestCase {
  public function testList(): void {
  }
  public function testCreate(): void {
    $entity = new ExecutionGroup();
    $pho = $this->createMock( SqlTemplate::class );
    $pho->method('execute')->willReturn( false );
    $pho->expects($this->once())->method('execute')->with('INSERT INTO execution_group ( uid, name, version) VALUES ( :uid, :name, :version)',[
     'uid' => $entity->getUid(),
     'name' => $entity->getName(),
     'version' => $entity->getVersion()
    ]);
    $repo = new ExecutionGroupSqlRepository($pho);
    $repo->create( $entity );
  }
  public function testRetrieve(): void {
  }
  public function testUpdate(): void {
  }
  public function testDelete(): void {
  }
  public function testExists(): void {
  }
}
