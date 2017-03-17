<?php

/**
 * actualizaciones actions.
 *
 * @package    sig
 * @subpackage actualizaciones
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class actualizacionesActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->actualizacioness = Doctrine_Core::getTable('Actualizaciones')
      ->createQuery('a')
      ->execute();
  }

  public function executeMasivas(sfWebRequest $request)
  {
   
    $this->archivos_profesionaless = Doctrine_Core::getTable('Actualizaciones')
      ->createQuery('a')
      ->orderby(nombre)
      ->execute();  

    $this->ficheros = array();  

    foreach($this->archivos_profesionaless as $archivos){
        $targetFolder = sfConfig::get('app_pathfiles_folder')."/../actualizaciones".'/'.$archivos->getNombre();  
         
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

      $this->ficheros[] = array($archivos->getNombre(), $archivos->getImagefile(), $image_file, $archivos->getId());
    
      sort($this->ficheros);
    }  
      
  }

  public function executeDeletefile(sfWebRequest $request)
  {
    // Redirige al inicio si no tiene acceso
      if (!$this->getUser()->getGuardUser()->getIsSuperAdmin())
         $this->redirect('ingreso');

       $archivo = Doctrine_Core::getTable('Actualizaciones')->find(array($request['id']));

      unlink(sfConfig::get('app_pathfiles_folder')."/../actualizaciones".'/'.$archivo->getImagefile());

      $archivo->delete();

      return true;  

  }

   public function executeProcesarfile()
  {
    // Redirige al inicio si no tiene acceso
      if (!$this->getUser()->getGuardUser()->getIsSuperAdmin())
         $this->redirect('ingreso');

     //  $archivo = Doctrine_Core::getTable('Actualizaciones')->find(array($request['id']));
      $archivo = Doctrine_Core::getTable('Actualizaciones')->find(array(1));

       $nombre_archivo = sfConfig::get('app_pathfiles_folder')."/../actualizaciones".'/'.$archivo->getImagefile();

       $nombre_archivo = "/home/projects/circulo/web/actualizaciones/demo.csv";

      // DATOS conexion
      $dbhost = 'localhost';$dbname = 'circulo';  $dbuser = 'root'; $dbpass = 'root911';

      $sqlTruncate = "TRUNCATE TABLE tmp_pacientes;";

      $sqlLoadInput = "LOAD DATA LOCAL INFILE '/home/projects/circulo/web/actualizaciones/demo.csv'
         INTO TABLE tmp_pacientes
         FIELDS TERMINATED BY ','
         OPTIONALLY ENCLOSED BY '\"'
         LINES TERMINATED BY '\n'
         IGNORE 1 LINES;"; 


      $pdo = new \PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname, $dbuser, $dbpass, array(
        \PDO::MYSQL_ATTR_LOCAL_INFILE => true
      ));

      //TRUNCAR TABLA TEMPORAL
      $query = $pdo->prepare($sqlTruncate);
      $query->execute();
   
      //PROCESAR INFORMACON DEL ARCHIVO
      $query = $pdo->prepare($sqlLoadInput);
      $query->execute();

      return true;  

  }

  public function executeShow(sfWebRequest $request)
  {
    $this->actualizaciones = Doctrine_Core::getTable('Actualizaciones')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->actualizaciones);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new ActualizacionesForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new ActualizacionesForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($actualizaciones = Doctrine_Core::getTable('Actualizaciones')->find(array($request->getParameter('id'))), sprintf('Object actualizaciones does not exist (%s).', $request->getParameter('id')));
    $this->form = new ActualizacionesForm($actualizaciones);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($actualizaciones = Doctrine_Core::getTable('Actualizaciones')->find(array($request->getParameter('id'))), sprintf('Object actualizaciones does not exist (%s).', $request->getParameter('id')));
    $this->form = new ActualizacionesForm($actualizaciones);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($actualizaciones = Doctrine_Core::getTable('Actualizaciones')->find(array($request->getParameter('id'))), sprintf('Object actualizaciones does not exist (%s).', $request->getParameter('id')));
    $actualizaciones->delete();

    $this->redirect('actualizaciones/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $actualizaciones = $form->save();

      $idorden = intval($request->getPostParameter('$archivos_profesionales[idorden]'));

      if (($idorden<>"") && ($idorden !== NULL) && ($idorden>0)){
            $actualizaciones->setIdorden($idorden);
      }


      $folder_path_name = sfConfig::get('app_pathfiles_folder')."/../actualizaciones";
      
      if (!is_dir($folder_path_name) && !mkdir($folder_path_name)){
          die("Error creando carpeta $uploaddir");
      }
      
      $hasfile =false;
      foreach ($request->getFiles() as $fileName) {
           $targetFolder = sfConfig::get('app_pathfiles_folder')."/../actualizaciones".'/'.$fileName['imagefile']['name'];
           move_uploaded_file($fileName['imagefile']['tmp_name'], $targetFolder);
           $hasfile = true;
     
      }
    
      if ($hasfile && trim($fileName['imagefile']['name'])<>'') 
         $actualizaciones->setImagefile($fileName['imagefile']['name']);
   

      $actualizaciones->save();

      $this->redirect('actualizaciones/edit?id='.$actualizaciones->getId());
    }
  }
}