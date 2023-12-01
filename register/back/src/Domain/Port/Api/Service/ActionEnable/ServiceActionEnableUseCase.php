<?php
namespace Register\Domain\Port\Api\Service\ActionEnable;


interface ServiceActionEnableUseCase {
  public function actionEnable(ServiceActionEnableRequest $request): ServiceActionEnableResponse;
}
