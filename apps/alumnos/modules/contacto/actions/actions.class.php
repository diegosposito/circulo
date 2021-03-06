<?php

/**
 * contacto actions.
 *
 * @package    sig
 * @subpackage contacto
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class contactoActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  { 
    // Redirige al inicio si no tiene acceso
    if ($this->getUser()->getGuardUser()) {
       if (!$this->getUser()->getGuardUser()->getIsSuperAdmin())
        $this->redirect('ingreso');
    } else {
       $this->redirect('ingreso');
    }

    $this->contactos = Doctrine_Core::getTable('Contacto')
      ->createQuery('a')
      ->orderBy('a.created_at DESC limit 100')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->contacto = Doctrine_Core::getTable('Contacto')->find(array($request->getParameter('idcontacto')));
    $this->forward404Unless($this->contacto);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new ContactoForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new ContactoForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    // Redirige al inicio si no tiene acceso
    if ($this->getUser()->getGuardUser()) {
       if (!$this->getUser()->getGuardUser()->getIsSuperAdmin())
        $this->redirect('ingreso');
    } else {
       $this->redirect('ingreso');
    }
     
    $this->forward404Unless($contacto = Doctrine_Core::getTable('Contacto')->find(array($request->getParameter('idcontacto'))), sprintf('Object contacto does not exist (%s).', $request->getParameter('idcontacto')));
    $this->form = new ContactoForm($contacto);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($contacto = Doctrine_Core::getTable('Contacto')->find(array($request->getParameter('idcontacto'))), sprintf('Object contacto does not exist (%s).', $request->getParameter('idcontacto')));
    $this->form = new ContactoForm($contacto);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    // Redirige al inicio si no tiene acceso
    if ($this->getUser()->getGuardUser()) {
       if (!$this->getUser()->getGuardUser()->getIsSuperAdmin())
        $this->redirect('ingreso');
    } else {
       $this->redirect('ingreso');
    }
     

    $request->checkCSRFProtection();

    $this->forward404Unless($contacto = Doctrine_Core::getTable('Contacto')->find(array($request->getParameter('idcontacto'))), sprintf('Object contacto does not exist (%s).', $request->getParameter('idcontacto')));
    $contacto->delete();

    $this->redirect('contacto/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $contacto = $form->save();

      $this->redirect('contacto/show?idcontacto='.$contacto->getIdcontacto());
    }
  }
}
