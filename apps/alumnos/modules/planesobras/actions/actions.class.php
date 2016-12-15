<?php

/**
 * planesobras actions.
 *
 * @package    sig
 * @subpackage planesobras
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class planesobrasActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->planes_obrass = Doctrine_Core::getTable('PlanesObras')
      ->createQuery('a')
      ->innerJoin('a.ObrasSociales os')
      ->orderBy('os.abreviada ASC, a.nombre ASC')
      ->execute();

  }

  public function executeShow(sfWebRequest $request)
  {
    $this->planes_obras = Doctrine_Core::getTable('PlanesObras')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->planes_obras);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new PlanesObrasForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new PlanesObrasForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($planes_obras = Doctrine_Core::getTable('PlanesObras')->find(array($request->getParameter('id'))), sprintf('Object planes_obras does not exist (%s).', $request->getParameter('id')));
    $this->form = new PlanesObrasForm($planes_obras);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($planes_obras = Doctrine_Core::getTable('PlanesObras')->find(array($request->getParameter('id'))), sprintf('Object planes_obras does not exist (%s).', $request->getParameter('id')));
    $this->form = new PlanesObrasForm($planes_obras);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($planes_obras = Doctrine_Core::getTable('PlanesObras')->find(array($request->getParameter('id'))), sprintf('Object planes_obras does not exist (%s).', $request->getParameter('id')));
    $planes_obras->delete();

    $this->redirect('planesobras/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $planes_obras = $form->save();

      $this->redirect('planesobras/edit?id='.$planes_obras->getId());
    }
  }
}
