<?php
namespace Register\Domain\Port\Api\Host\Retrieve;


interface HostRetrieveUseCase {
  public function Retrieve(HostRetrieveRequest $request): HostRetrieveResponse;
}
