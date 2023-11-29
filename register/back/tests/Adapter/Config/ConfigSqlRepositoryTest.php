<?php

use PHPUnit\Framework\TestCase;
use Civi\Micro\Sql\SqlTemplate;
use Register\Adapter\Config\ConfigSqlRepository;
use Register\Domain\Model\Config;
use Register\Domain\Model\Ref\Config\ConfigRef;
use Register\Domain\Model\Query\Config\ConfigFilter;
use Register\Domain\Model\Query\Config\ConfigSort;

final class ConfigSqlRepositoryTest extends TestCase {
  public function testList(): void {
  }
  public function testCreate(): void {
    $entity = new Config();
    $pho = $this->createMock( SqlTemplate::class );
    $pho->method('execute')->willReturn( false );
    $pho->expects($this->once())->method('execute')->with('INSERT INTO config ( uid, service, property, value, version) VALUES ( :uid, :service, :property, :value, :version)',[
     'uid' => $entity->getUid(),
     'service' => $entity->getService()?->getUid(),
     'property' => $entity->getProperty(),
     'value' => $entity->getValue(),
     'version' => $entity->getVersion()
    ]);
    $repo = new ConfigSqlRepository($pho);
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
