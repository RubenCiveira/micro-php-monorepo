<?php
namespace Register\Domain\Port\Api\Host\List;


interface HostListUseCase {
  public function List(HostListRequest $request): HostListResponse;
}
