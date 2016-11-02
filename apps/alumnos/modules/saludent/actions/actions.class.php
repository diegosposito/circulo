<?php

/**
 * saludent actions.
 *
 * @package    sig
 * @subpackage saludent
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class saludentActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->saludent_contenidos = Doctrine_Core::getTable('SaludentContenido')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->saludent_contenido = Doctrine_Core::getTable('SaludentContenido')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->saludent_contenido);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new SaludentContenidoForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new SaludentContenidoForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($saludent_contenido = Doctrine_Core::getTable('SaludentContenido')->find(array($request->getParameter('id'))), sprintf('Object saludent_contenido does not exist (%s).', $request->getParameter('id')));
    $this->form = new SaludentContenidoForm($saludent_contenido);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($saludent_contenido = Doctrine_Core::getTable('SaludentContenido')->find(array($request->getParameter('id'))), sprintf('Object saludent_contenido does not exist (%s).', $request->getParameter('id')));
    $this->form = new SaludentContenidoForm($saludent_contenido);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($saludent_contenido = Doctrine_Core::getTable('SaludentContenido')->find(array($request->getParameter('id'))), sprintf('Object saludent_contenido does not exist (%s).', $request->getParameter('id')));
    $saludent_contenido->delete();

    $this->redirect('saludent/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $saludent_contenido = $form->save();

      $this->redirect('saludent/edit?id='.$saludent_contenido->getId());
    }
  }
}
