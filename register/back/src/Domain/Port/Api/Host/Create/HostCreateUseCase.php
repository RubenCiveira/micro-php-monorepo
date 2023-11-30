<?php
namespace Register\Domain\Port\Api\Host\Create;


interface HostCreateUseCase {
  public function create(HostCreateRequest $request): HostCreateResponse;
}
