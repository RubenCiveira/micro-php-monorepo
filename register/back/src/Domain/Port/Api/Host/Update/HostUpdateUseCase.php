<?php
namespace Register\Domain\Port\Api\Host\Update;


interface HostUpdateUseCase {
  public function update(HostUpdateRequest $request): HostUpdateResponse;
}
