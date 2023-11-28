<?php
return function($context) {
  $context->bind(Register\Domain\Port\Spi\ServiceRepository::class)->to(Register\Adapter\Service\ServicePdoRepository::class);
  $context->bind(Register\Domain\Port\Spi\HostRepository::class)->to(Register\Adapter\Host\HostPdoRepository::class);
  $context->bind(Register\Domain\Port\Spi\ConfigRepository::class)->to(Register\Adapter\Config\ConfigPdoRepository::class);
}
