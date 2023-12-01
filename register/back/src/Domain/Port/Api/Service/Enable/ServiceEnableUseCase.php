<?php
namespace Register\Domain\Port\Api\Service\Enable;


interface ServiceEnableUseCase {
  public function enable(ServiceEnableRequest $request): ServiceEnableResponse;
}
