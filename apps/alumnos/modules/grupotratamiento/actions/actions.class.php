<?php

/**
 * grupotratamiento actions.
 *
 * @package    sig
 * @subpackage grupotratamiento
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class grupotratamientoActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->grupo_tratamientos = Doctrine_Core::getTable('GrupoTratamiento')
      ->createQuery('a')
      ->orderBy('nombre')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->grupo_tratamiento = Doctrine_Core::getTable('GrupoTratamiento')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->grupo_tratamiento);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new GrupoTratamientoForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new GrupoTratamientoForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($grupo_tratamiento = Doctrine_Core::getTable('GrupoTratamiento')->find(array($request->getParameter('id'))), sprintf('Object grupo_tratamiento does not exist (%s).', $request->getParameter('id')));
    $this->form = new GrupoTratamientoForm($grupo_tratamiento);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($grupo_tratamiento = Doctrine_Core::getTable('GrupoTratamiento')->find(array($request->getParameter('id'))), sprintf('Object grupo_tratamiento does not exist (%s).', $request->getParameter('id')));
    $this->form = new GrupoTratamientoForm($grupo_tratamiento);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($grupo_tratamiento = Doctrine_Core::getTable('GrupoTratamiento')->find(array($request->getParameter('id'))), sprintf('Object grupo_tratamiento does not exist (%s).', $request->getParameter('id')));
    $grupo_tratamiento->delete();

    $this->redirect('grupotratamiento/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $grupo_tratamiento = $form->save();

      $this->redirect('grupotratamiento/edit?id='.$grupo_tratamiento->getId());
    }
  }
}
