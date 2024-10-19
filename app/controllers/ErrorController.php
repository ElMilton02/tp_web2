<?php

class ErrorController
{

  public function showErrorInvalidUser($error)
  {

    require_once './templates/login.phtml';
  }

  public function showErrorNonData($error)
  {

    require_once './templates/login.phtml';
  }

  public function showErrorNonDataDestino($error, $model)
  {
    $categories = $model->getDestinos();
    $view = new DestinoView();
    $view->showDestinos($categories, $error);
  }

  public function showErrorInsert($error)
  {

    require_once './templates/login.phtml';
  }

  public function showErrorDelete($error, $model)
  {
    $destinos = $model->getDestinos();
    $view = new DestinoView();
    $view->showDestinos($destinos, $error);
  }
  
  public function showErrorNonUser($error, $page)
  {

    if ($page == 'home') {
      $view = new HomeView();
      $view->showHome($error);
    }
  }

  public function showError404($error = null)
  {
    $view = new HomeView();
    $view->showHome($error);
  }

  public function showErrorNonDataViajes($error, $model, $destinoId)
  {
    $listViajes = $model->getViajesByDestino($destinoId);
    $view = new ViajeView();
    $view->showViajesByDestinoId($listViajes, $destinoId, $error = null);
  }
}
