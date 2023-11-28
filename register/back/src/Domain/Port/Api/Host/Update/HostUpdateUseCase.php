<?php
namespace Register\Domain\Port\Api\Host\Update;


interface HostUpdateUseCase {
  public function Update(HostUpdateRequest $request): HostUpdateResponse;}
