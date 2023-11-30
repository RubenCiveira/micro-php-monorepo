<?php
namespace Register\Domain\Port\Api\Host\List;


interface HostListUseCase {
  public function list(HostListRequest $request): HostListResponse;
}
