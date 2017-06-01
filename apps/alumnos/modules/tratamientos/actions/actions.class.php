<?php

/**
 * tratamientos actions.
 *
 * @package    sig
 * @subpackage tratamientos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tratamientosActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->tratamientoss = Doctrine_Core::getTable('Tratamientos')->obtenerTratamientos();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->tratamientos = Doctrine_Core::getTable('Tratamientos')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->tratamientos);
  }

  // Obtiene tratamiento por idtratamiento
  public function executeObtenertratamiento(sfWebRequest $request)  {
    $this->tratamiento = Doctrine_Core::getTable('Tratamientos')->find($request->getParameter('idtratamiento'));
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new TratamientosForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new TratamientosForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($tratamientos = Doctrine_Core::getTable('Tratamientos')->find(array($request->getParameter('id'))), sprintf('Object tratamientos does not exist (%s).', $request->getParameter('id')));
    $this->form = new TratamientosForm($tratamientos);
    $this->idplan = $tratamientos->getIdplan();
    $this->idobrasocial = $tratamientos->getIdobrasocial();
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($tratamientos = Doctrine_Core::getTable('Tratamientos')->find(array($request->getParameter('id'))), sprintf('Object tratamientos does not exist (%s).', $request->getParameter('id')));
    $this->form = new TratamientosForm($tratamientos);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($tratamientos = Doctrine_Core::getTable('Tratamientos')->find(array($request->getParameter('id'))), sprintf('Object tratamientos does not exist (%s).', $request->getParameter('id')));
    $tratamientos->delete();

    $this->redirect('tratamientos/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $tratamientos = $form->save();

      $this->redirect('tratamientos/edit?id='.$tratamientos->getId());
    }
  }
}
