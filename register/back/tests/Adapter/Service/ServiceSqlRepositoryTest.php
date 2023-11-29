<?php

use PHPUnit\Framework\TestCase;
use Civi\Micro\Sql\SqlTemplate;
use Register\Adapter\Service\ServiceSqlRepository;
use Register\Domain\Model\Service;
use Register\Domain\Model\Ref\Service\ServiceRef;
use Register\Domain\Model\Query\Service\ServiceFilter;
use Register\Domain\Model\Query\Service\ServiceSort;

final class ServiceSqlRepositoryTest extends TestCase {
  public function testList(): void {
  }
  public function testCreate(): void {
    $entity = new Service();
    $pho = $this->createMock( SqlTemplate::class );
    $pho->method('execute')->willReturn( false );
    $pho->expects($this->once())->method('execute')->with('INSERT INTO service ( uid, name, version) VALUES ( :uid, :name, :version)',[
     'uid' => $entity->getUid(),
     'name' => $entity->getName(),
     'version' => $entity->getVersion()
    ]);
    $repo = new ServiceSqlRepository($pho);
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
