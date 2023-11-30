<?php
return function($context) {
  $context->bind(Register\Domain\Port\Api\Config\List\ConfigListUseCase::class)->to(Register\Domain\Impl\Config\ConfigListImpl::class);
  $context->bind(Register\Domain\Port\Api\Config\Create\ConfigCreateUseCase::class)->to(Register\Domain\Impl\Config\ConfigCreateImpl::class);
  $context->bind(Register\Domain\Port\Api\Config\Retrieve\ConfigRetrieveUseCase::class)->to(Register\Domain\Impl\Config\ConfigRetrieveImpl::class);
  $context->bind(Register\Domain\Port\Api\Config\Update\ConfigUpdateUseCase::class)->to(Register\Domain\Impl\Config\ConfigUpdateImpl::class);
  $context->bind(Register\Domain\Port\Api\Config\Delete\ConfigDeleteUseCase::class)->to(Register\Domain\Impl\Config\ConfigDeleteImpl::class);
};
