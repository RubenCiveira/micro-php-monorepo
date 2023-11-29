<?php

use PHPUnit\Framework\TestCase;
use Civi\Micro\Sql\SqlTemplate;
use Register\Adapter\Host\HostSqlRepository;
use Register\Domain\Model\Host;
use Register\Domain\Model\Ref\Host\HostRef;
use Register\Domain\Model\Query\Host\HostFilter;
use Register\Domain\Model\Query\Host\HostSort;

final class HostSqlRepositoryTest extends TestCase {
  public function testList(): void {
  }
  public function testCreate(): void {
    $entity = new Host();
    $pho = $this->createMock( SqlTemplate::class );
    $pho->method('execute')->willReturn( false );
    $pho->expects($this->once())->method('execute')->with('INSERT INTO host ( uid, name, service, version) VALUES ( :uid, :name, :service, :version)',[
     'uid' => $entity->getUid(),
     'name' => $entity->getName(),
     'service' => $entity->getService()?->getUid(),
     'version' => $entity->getVersion()
    ]);
    $repo = new HostSqlRepository($pho);
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
