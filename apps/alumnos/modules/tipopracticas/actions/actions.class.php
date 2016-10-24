<?php

/**
 * tipopracticas actions.
 *
 * @package    sig
 * @subpackage tipopracticas
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tipopracticasActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->tipo_practicass = Doctrine_Core::getTable('TipoPracticas')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->tipo_practicas = Doctrine_Core::getTable('TipoPracticas')->find(array($request->getParameter('idtipopractica')));
    $this->forward404Unless($this->tipo_practicas);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new TipoPracticasForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new TipoPracticasForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($tipo_practicas = Doctrine_Core::getTable('TipoPracticas')->find(array($request->getParameter('idtipopractica'))), sprintf('Object tipo_practicas does not exist (%s).', $request->getParameter('idtipopractica')));
    $this->form = new TipoPracticasForm($tipo_practicas);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($tipo_practicas = Doctrine_Core::getTable('TipoPracticas')->find(array($request->getParameter('idtipopractica'))), sprintf('Object tipo_practicas does not exist (%s).', $request->getParameter('idtipopractica')));
    $this->form = new TipoPracticasForm($tipo_practicas);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($tipo_practicas = Doctrine_Core::getTable('TipoPracticas')->find(array($request->getParameter('idtipopractica'))), sprintf('Object tipo_practicas does not exist (%s).', $request->getParameter('idtipopractica')));
    $tipo_practicas->delete();

    $this->redirect('tipopracticas/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $tipo_practicas = $form->save();

      $this->redirect('tipopracticas/edit?idtipopractica='.$tipo_practicas->getIdtipopractica());
    }
  }
}
