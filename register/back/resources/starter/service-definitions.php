<?php
return function($context) {
  $context->bind(Register\Domain\Impl\Service\ServiceVisibilityFilter::class);
  $context->bind(Register\Domain\Impl\Service\ServiceReadFilter::class);
  $context->bind(Register\Domain\Impl\Service\ServicePropertyEnabledCalculator::class);
  $context->bind(Register\Domain\Impl\Service\ServicePropertiesCalculator::class);
  $context->bind(Register\Domain\Impl\Service\ServiceWriteFilter::class);
  $context->bind(Register\Domain\Port\Api\Service\List\ServiceListUseCase::class)->to(Register\Domain\Impl\Service\ServiceListImpl::class);
  $context->bind(Register\Domain\Port\Api\Service\Create\ServiceCreateUseCase::class)->to(Register\Domain\Impl\Service\ServiceCreateImpl::class);
  $context->bind(Register\Domain\Port\Api\Service\Retrieve\ServiceRetrieveUseCase::class)->to(Register\Domain\Impl\Service\ServiceRetrieveImpl::class);
  $context->bind(Register\Domain\Port\Api\Service\Update\ServiceUpdateUseCase::class)->to(Register\Domain\Impl\Service\ServiceUpdateImpl::class);
  $context->bind(Register\Domain\Port\Api\Service\Delete\ServiceDeleteUseCase::class)->to(Register\Domain\Impl\Service\ServiceDeleteImpl::class);
  $context->bind(Register\Domain\Impl\Host\HostVisibilityFilter::class);
  $context->bind(Register\Domain\Impl\Host\HostReadFilter::class);
  $context->bind(Register\Domain\Impl\Host\HostWriteFilter::class);
  $context->bind(Register\Domain\Port\Api\Host\List\HostListUseCase::class)->to(Register\Domain\Impl\Host\HostListImpl::class);
  $context->bind(Register\Domain\Port\Api\Host\Create\HostCreateUseCase::class)->to(Register\Domain\Impl\Host\HostCreateImpl::class);
  $context->bind(Register\Domain\Port\Api\Host\Retrieve\HostRetrieveUseCase::class)->to(Register\Domain\Impl\Host\HostRetrieveImpl::class);
  $context->bind(Register\Domain\Port\Api\Host\Update\HostUpdateUseCase::class)->to(Register\Domain\Impl\Host\HostUpdateImpl::class);
  $context->bind(Register\Domain\Port\Api\Host\Delete\HostDeleteUseCase::class)->to(Register\Domain\Impl\Host\HostDeleteImpl::class);
  $context->bind(Register\Domain\Impl\Config\ConfigVisibilityFilter::class);
  $context->bind(Register\Domain\Impl\Config\ConfigReadFilter::class);
  $context->bind(Register\Domain\Impl\Config\ConfigWriteFilter::class);
  $context->bind(Register\Domain\Port\Api\Config\List\ConfigListUseCase::class)->to(Register\Domain\Impl\Config\ConfigListImpl::class);
  $context->bind(Register\Domain\Port\Api\Config\Create\ConfigCreateUseCase::class)->to(Register\Domain\Impl\Config\ConfigCreateImpl::class);
  $context->bind(Register\Domain\Port\Api\Config\Retrieve\ConfigRetrieveUseCase::class)->to(Register\Domain\Impl\Config\ConfigRetrieveImpl::class);
  $context->bind(Register\Domain\Port\Api\Config\Update\ConfigUpdateUseCase::class)->to(Register\Domain\Impl\Config\ConfigUpdateImpl::class);
  $context->bind(Register\Domain\Port\Api\Config\Delete\ConfigDeleteUseCase::class)->to(Register\Domain\Impl\Config\ConfigDeleteImpl::class);
};
