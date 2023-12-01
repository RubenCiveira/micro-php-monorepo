<?php
namespace Register\Domain\Port\Api\Service\ActionDisable;


interface ServiceActionDisableUseCase {
  public function actionDisable(ServiceActionDisableRequest $request): ServiceActionDisableResponse;
}
