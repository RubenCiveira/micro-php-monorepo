<?php
namespace Register\Domain\Port\Api\Service\Disable;


interface ServiceDisableUseCase {
  public function disable(ServiceDisableRequest $request): ServiceDisableResponse;
}
