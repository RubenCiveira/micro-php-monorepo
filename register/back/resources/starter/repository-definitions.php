<?php
return function($context) {
  $context->bind(Register\Domain\Port\Spi\Agent\AgentRepository::class)->to(Register\Adapter\Agent\AgentSqlRepository::class);
  $context->bind(Register\Domain\Port\Spi\Service\ServiceRepository::class)->to(Register\Adapter\Service\ServiceSqlRepository::class);
  $context->bind(Register\Domain\Port\Spi\Host\HostRepository::class)->to(Register\Adapter\Host\HostSqlRepository::class);
  $context->bind(Register\Domain\Port\Spi\AgentExecutionGroup\AgentExecutionGroupRepository::class)->to(Register\Adapter\AgentExecutionGroup\AgentExecutionGroupSqlRepository::class);
  $context->bind(Register\Domain\Port\Spi\Config\ConfigRepository::class)->to(Register\Adapter\Config\ConfigSqlRepository::class);
  $context->bind(Register\Domain\Port\Spi\ExecutionGroup\ExecutionGroupRepository::class)->to(Register\Adapter\ExecutionGroup\ExecutionGroupSqlRepository::class);
};
