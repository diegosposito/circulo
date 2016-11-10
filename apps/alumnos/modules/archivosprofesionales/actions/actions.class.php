<?php

/**
 * archivosprofesionales actions.
 *
 * @package    sig
 * @subpackage archivosprofesionales
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class archivosprofesionalesActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $archivos_profesionaless = Doctrine_Core::getTable('ArchivosProfesionales')
      ->createQuery('a')
      ->orderby(nombre)
      ->execute();

    $this->archivos_profesionaless = Doctrine_Core::getTable('ArchivosProfesionales')
      ->createQuery('a')
      ->orderby(nombre)
      ->execute();  

    $this->ficheros = array();  

    foreach($archivos_profesionaless as $archivos){
        $targetFolder = sfConfig::get('app_pathfiles_folder')."/../archivosprofesionales".'/'.$archivos->getNombre();  
         
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

       $archivo = Doctrine_Core::getTable('ArchivosProfesionales')->find(array($request['id']));

      unlink(sfConfig::get('app_pathfiles_folder')."/../archivosprofesionales".'/'.$archivo->getImagefile());

      $archivo->delete();

      return true;  

  }

  public function executeShow(sfWebRequest $request)
  {
    $this->archivos_profesionales = Doctrine_Core::getTable('ArchivosProfesionales')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->archivos_profesionales);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new ArchivosProfesionalesForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new ArchivosProfesionalesForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($archivos_profesionales = Doctrine_Core::getTable('ArchivosProfesionales')->find(array($request->getParameter('id'))), sprintf('Object archivos_profesionales does not exist (%s).', $request->getParameter('id')));
    $this->form = new ArchivosProfesionalesForm($archivos_profesionales);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($archivos_profesionales = Doctrine_Core::getTable('ArchivosProfesionales')->find(array($request->getParameter('id'))), sprintf('Object archivos_profesionales does not exist (%s).', $request->getParameter('id')));
    $this->form = new ArchivosProfesionalesForm($archivos_profesionales);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($archivos_profesionales = Doctrine_Core::getTable('ArchivosProfesionales')->find(array($request->getParameter('id'))), sprintf('Object archivos_profesionales does not exist (%s).', $request->getParameter('id')));
    $archivos_profesionales->delete();

    $this->redirect('archivosprofesionales/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $archivos_profesionales = $form->save();


      if ($request->getPostParameter('archivos_profesionales[visible]') == 'on') {
        $archivos_profesionales->setVisible(1);
      } else {
        $archivos_profesionales->setVisible(0);
      }
      $idorden = intval($request->getPostParameter('$archivos_profesionales[idorden]'));

      if (($idorden<>"") && ($idorden !== NULL) && ($idorden>0)){
            $archivos_profesionales->setIdorden($idorden);
      }


      $folder_path_name = sfConfig::get('app_pathfiles_folder')."/../archivosprofesionales";
      
      if (!is_dir($folder_path_name) && !mkdir($folder_path_name)){
          die("Error creando carpeta $uploaddir");
      }
      
      $hasfile =false;
      foreach ($request->getFiles() as $fileName) {
           $targetFolder = sfConfig::get('app_pathfiles_folder')."/../archivosprofesionales".'/'.$fileName['imagefile']['name'];
           move_uploaded_file($fileName['imagefile']['tmp_name'], $targetFolder);
           $hasfile = true;
     
      }
    
      if ($hasfile && trim($fileName['imagefile']['name'])<>'') 
         $archivos_profesionales->setImagefile($fileName['imagefile']['name']);
   

      $archivos_profesionales->save();

      $this->redirect('archivosprofesionales/edit?id='.$archivos_profesionales->getId());
    }
  }
}
