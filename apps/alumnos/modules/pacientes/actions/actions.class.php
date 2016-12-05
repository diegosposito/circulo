<?php

/**
 * pacientes actions.
 *
 * @package    sig
 * @subpackage pacientes
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class pacientesActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->pacientess = Doctrine_Core::getTable('Pacientes')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->pacientes = Doctrine_Core::getTable('Pacientes')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->pacientes);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new PacientesForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new PacientesForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($pacientes = Doctrine_Core::getTable('Pacientes')->find(array($request->getParameter('id'))), sprintf('Object pacientes does not exist (%s).', $request->getParameter('id')));
    $this->form = new PacientesForm($pacientes);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($pacientes = Doctrine_Core::getTable('Pacientes')->find(array($request->getParameter('id'))), sprintf('Object pacientes does not exist (%s).', $request->getParameter('id')));
    $this->form = new PacientesForm($pacientes);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($pacientes = Doctrine_Core::getTable('Pacientes')->find(array($request->getParameter('id'))), sprintf('Object pacientes does not exist (%s).', $request->getParameter('id')));
    $pacientes->delete();

    $this->redirect('pacientes/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $pacientes = $form->save();

      $this->redirect('pacientes/edit?id='.$pacientes->getId());
    }
  }
}
