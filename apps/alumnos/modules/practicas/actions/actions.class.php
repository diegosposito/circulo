<?php

/**
 * practicas actions.
 *
 * @package    sig
 * @subpackage practicas
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class practicasActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->practicass = Doctrine_Core::getTable('Practicas')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->practicas = Doctrine_Core::getTable('Practicas')->find(array($request->getParameter('idpractica')));
    $this->forward404Unless($this->practicas);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new PracticasForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new PracticasForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($practicas = Doctrine_Core::getTable('Practicas')->find(array($request->getParameter('idpractica'))), sprintf('Object practicas does not exist (%s).', $request->getParameter('idpractica')));
    $this->form = new PracticasForm($practicas);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($practicas = Doctrine_Core::getTable('Practicas')->find(array($request->getParameter('idpractica'))), sprintf('Object practicas does not exist (%s).', $request->getParameter('idpractica')));
    $this->form = new PracticasForm($practicas);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($practicas = Doctrine_Core::getTable('Practicas')->find(array($request->getParameter('idpractica'))), sprintf('Object practicas does not exist (%s).', $request->getParameter('idpractica')));
    $practicas->delete();

    $this->redirect('practicas/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $practicas = $form->save();
      $practicas->setImporte($request->getPostParameter('practicas[importe]'));
      $practicas->setCodigo($request->getPostParameter('practicas[codigo]'));
    

      $practicas->save();

      $this->redirect('practicas/edit?idpractica='.$practicas->getIdpractica());
    }
  }
}
