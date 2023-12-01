<?php

use PHPUnit\Framework\TestCase;
use Civi\Micro\Sql\SqlTemplate;
use Register\Adapter\Agent\AgentSqlRepository;
use Register\Domain\Model\Agent;
use Register\Domain\Model\Ref\Agent\AgentRef;
use Register\Domain\Model\Query\Agent\AgentFilter;
use Register\Domain\Model\Query\Agent\AgentSort;

final class AgentSqlRepositoryTest extends TestCase {
  public function testList(): void {
  }
  public function testCreate(): void {
    $entity = new Agent();
    $pho = $this->createMock( SqlTemplate::class );
    $pho->method('execute')->willReturn( false );
    $pho->expects($this->once())->method('execute')->with('INSERT INTO agent ( uid, name, groups, version) VALUES ( :uid, :name, :groups, :version)',[
     'uid' => $entity->getUid(),
     'name' => $entity->getName(),
     'version' => $entity->getVersion()
    ]);
    $repo = new AgentSqlRepository($pho);
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
