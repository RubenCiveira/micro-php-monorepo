<?php
return function($context) {
  $context->bind(Register\Domain\Port\Api\Host\List\HostListUseCase::class)->to(Register\Domain\Impl\Host\HostListImpl::class);
  $context->bind(Register\Domain\Port\Api\Host\Create\HostCreateUseCase::class)->to(Register\Domain\Impl\Host\HostCreateImpl::class);
  $context->bind(Register\Domain\Port\Api\Host\Retrieve\HostRetrieveUseCase::class)->to(Register\Domain\Impl\Host\HostRetrieveImpl::class);
  $context->bind(Register\Domain\Port\Api\Host\Update\HostUpdateUseCase::class)->to(Register\Domain\Impl\Host\HostUpdateImpl::class);
  $context->bind(Register\Domain\Port\Api\Host\Delete\HostDeleteUseCase::class)->to(Register\Domain\Impl\Host\HostDeleteImpl::class);
};
