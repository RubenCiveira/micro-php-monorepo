<?php
return function($context) {
  $context->bind(Register\Domain\Port\Api\Service\List\ServiceListUseCase::class)->to(Register\Domain\Impl\Service\ServiceListImpl::class);
  $context->bind(Register\Domain\Port\Api\Service\Create\ServiceCreateUseCase::class)->to(Register\Domain\Impl\Service\ServiceCreateImpl::class);
  $context->bind(Register\Domain\Port\Api\Service\Retrieve\ServiceRetrieveUseCase::class)->to(Register\Domain\Impl\Service\ServiceRetrieveImpl::class);
  $context->bind(Register\Domain\Port\Api\Service\Update\ServiceUpdateUseCase::class)->to(Register\Domain\Impl\Service\ServiceUpdateImpl::class);
  $context->bind(Register\Domain\Port\Api\Service\Delete\ServiceDeleteUseCase::class)->to(Register\Domain\Impl\Service\ServiceDeleteImpl::class);
};
