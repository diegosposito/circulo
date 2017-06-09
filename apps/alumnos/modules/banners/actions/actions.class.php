<?php

/**
 * banners actions.
 *
 * @package    sig
 * @subpackage banners
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class bannersActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
       $banners = Doctrine_Core::getTable('Banners')
      ->createQuery('a')
      ->orderby(nombre)
      ->execute();

    $this->bannerss = Doctrine_Core::getTable('Banners')
      ->createQuery('a')
      ->orderby(nombre)
      ->execute();

    $this->ficheros = array();

    foreach($banners as $archivos){
        $targetFolder = sfConfig::get('app_pathfiles_folder')."/../banners".'/'.$archivos->getNombre();

      $image_file = 'image.png';
      switch (pathinfo($archivos->getImagefile(), PATHINFO_EXTENSION)) {
          case 'pdf':
              $image_file = 'pdf.png';
              break;
          case 'doc':
              $image_file = 'word.png';
              break;
          case 'docx':
              $image_file = 'word.png';
              break;
          case 'xls':
              $image_file = 'excel.png';
              break;
          case 'xlsx':
              $image_file = 'excel.png';
              break;
          case 'txt':
              $image_file = 'wordpad.png';
              break;
          case 'ppt':
              $image_file = 'ppt.png';
              break;
          case 'pptx':
              $image_file = 'ppt.png';
              break;
      }

      $this->ficheros[] = array($archivos->getNombre(), $archivos->getImagefile(), $image_file, $archivos->getId(), $archivos->getVisible());

      sort($this->ficheros);

    }
  }

  public function executeDeletefile(sfWebRequest $request)
  {
    // Redirige al inicio si no tiene acceso
      if (!$this->getUser()->getGuardUser()->getIsSuperAdmin())
         $this->redirect('ingreso');

       $archivo = Doctrine_Core::getTable('Banners')->find(array($request['id']));

      unlink(sfConfig::get('app_pathfiles_folder')."/../banners".'/'.$archivo->getImagefile());

      $archivo->delete();

      return true;

  }

  public function executeShow(sfWebRequest $request)
  {
    $this->banners = Doctrine_Core::getTable('Banners')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->banners);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new BannersForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new BannersForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($banners = Doctrine_Core::getTable('Banners')->find(array($request->getParameter('id'))), sprintf('Object banners does not exist (%s).', $request->getParameter('id')));
    $this->form = new BannersForm($banners);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($banners = Doctrine_Core::getTable('Banners')->find(array($request->getParameter('id'))), sprintf('Object banners does not exist (%s).', $request->getParameter('id')));
    $this->form = new BannersForm($banners);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($banners = Doctrine_Core::getTable('Banners')->find(array($request->getParameter('id'))), sprintf('Object banners does not exist (%s).', $request->getParameter('id')));
    $banners->delete();

    $this->redirect('banners/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

    if ($form->isValid())
    {
      $banners = $form->save();

      if ($request->getPostParameter('banners[visible]') == 'on') {
        $banners->setVisible(1);
      } else {
        $banners->setVisible(0);
      }
      $idorden = $request->getPostParameter('$banners[idorden]');
      $coord = $request->getPostParameter('$banners[coordenada]');
      $url2 = $request->getPostParameter('$banners[urlsecundaria]');
      $coord2 = $request->getPostParameter('$banners[coordenadasec]');

      $banners->setCoordenada($coord);
      $banners->setUrlsecundaria($url2);
      $banners->setCoordenadasec($coord2);

      if (($idorden<>"") && ($idorden !== NULL) && ($idorden>0)){
            $banners->setIdorden($idorden);
      }



      $folder_path_name = sfConfig::get('app_pathfiles_folder')."/../banners";

      if (!is_dir($folder_path_name) && !mkdir($folder_path_name)){
          die("Error creando carpeta $uploaddir");
      }

      $hasfile =false;
      foreach ($request->getFiles() as $fileName) {
           $targetFolder = sfConfig::get('app_pathfiles_folder')."/../banners".'/'.$fileName['imagefile']['name'];
           move_uploaded_file($fileName['imagefile']['tmp_name'], $targetFolder);
           $hasfile = true;

      }

      if ($hasfile && trim($fileName['imagefile']['name'])<>'')
         $banners->setImagefile($fileName['imagefile']['name']);


      $banners->save();

      $this->redirect('banners/edit?id='.$banners->getId());
    }
  }
}
