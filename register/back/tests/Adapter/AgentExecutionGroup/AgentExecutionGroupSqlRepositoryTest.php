<?php

use PHPUnit\Framework\TestCase;
use Civi\Micro\Sql\SqlTemplate;
use Register\Adapter\AgentExecutionGroup\AgentExecutionGroupSqlRepository;
use Register\Domain\Model\AgentExecutionGroup;
use Register\Domain\Model\Ref\AgentExecutionGroup\AgentExecutionGroupRef;
use Register\Domain\Model\Query\AgentExecutionGroup\AgentExecutionGroupFilter;
use Register\Domain\Model\Query\AgentExecutionGroup\AgentExecutionGroupSort;

final class AgentExecutionGroupSqlRepositoryTest extends TestCase {
  public function testList(): void {
  }
  public function testCreate(): void {
    $entity = new AgentExecutionGroup();
    $pho = $this->createMock( SqlTemplate::class );
    $pho->method('execute')->willReturn( false );
    $pho->expects($this->once())->method('execute')->with('INSERT INTO agent_execution_group ( uid, agent, group, version) VALUES ( :uid, :agent, :group, :version)',[
     'uid' => $entity->getUid(),
     'agent' => $entity->getAgent()?->getUid(),
     'group' => $entity->getGroup()?->getUid(),
     'version' => $entity->getVersion()
    ]);
    $repo = new AgentExecutionGroupSqlRepository($pho);
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
