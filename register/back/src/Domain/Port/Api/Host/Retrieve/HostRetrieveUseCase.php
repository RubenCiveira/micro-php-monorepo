<?php
namespace Register\Domain\Port\Api\Host\Retrieve;


interface HostRetrieveUseCase {
  public function retrieve(HostRetrieveRequest $request): HostRetrieveResponse;
}
