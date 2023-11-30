<?php
namespace Register\Domain\Port\Api\Host\Create;


interface HostCreateUseCase {
  public function Create(HostCreateRequest $request): HostCreateResponse;
}
