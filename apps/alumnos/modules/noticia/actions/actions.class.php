<?php

/**
 * noticia actions.
 *
 * @package    sig
 * @subpackage noticia
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class noticiaActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->noticias = Doctrine_Core::getTable('Noticia')
      ->createQuery('a')
      ->orderBy('a.id DESC')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->noticia = Doctrine_Core::getTable('Noticia')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->noticia);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new NoticiaForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new NoticiaForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($noticia = Doctrine_Core::getTable('Noticia')->find(array($request->getParameter('id'))), sprintf('Object noticia does not exist (%s).', $request->getParameter('id')));
    $this->form = new NoticiaForm($noticia);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($noticia = Doctrine_Core::getTable('Noticia')->find(array($request->getParameter('id'))), sprintf('Object noticia does not exist (%s).', $request->getParameter('id')));
    $this->form = new NoticiaForm($noticia);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($noticia = Doctrine_Core::getTable('Noticia')->find(array($request->getParameter('id'))), sprintf('Object noticia does not exist (%s).', $request->getParameter('id')));
    $noticia->delete();

    $this->redirect('noticia/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $noticia = $form->save();

      if ($request->getPostParameter('noticia[visible]') == 'on') {
        $noticia->setVisible(1);
      } else {
        $noticia->setVisible(0);
      }
     
      $folder_path_name = sfConfig::get('app_pathfiles_folder')."/noticias/".$noticia->getId();
      
      if (!is_dir($folder_path_name) && !mkdir($folder_path_name)){
          die("Error creando carpeta $uploaddir");
      }
      
      $hasfile =false;
      foreach ($request->getFiles() as $fileName) {
           $targetFolder = sfConfig::get('app_pathfiles_folder')."/noticias/".$noticia->getId().'/'.$fileName['imagefile']['name'];
           move_uploaded_file($fileName['imagefile']['tmp_name'], $targetFolder);
           $hasfile = true;
     
      }
    
      if ($hasfile && trim($fileName['imagefile']['name'])<>'') 
         $noticia->setImagefile($fileName['imagefile']['name']);
      
      $noticia->setIdorden($noticia->getId());
      $noticia->save();

      $this->redirect('noticia/edit?id='.$noticia->getId());
    }
  }
}
