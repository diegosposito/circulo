<?php

/**
 * actualizacionesaten actions.
 *
 * @package    sig
 * @subpackage actualizacionesaten
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class actualizacionesatenActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->actualizacionesatens = Doctrine_Core::getTable('Actualizacionesaten')
      ->createQuery('a')
      ->execute();
  }

  public function executeMasivas(sfWebRequest $request)
  {

    $this->archivos_profesionaless = Doctrine_Core::getTable('Actualizacionesaten')
      ->createQuery('a')
      ->orderby(nombre)
      ->execute();

    $this->ficheros = array();

    foreach($this->archivos_profesionaless as $archivos){
        $targetFolder = sfConfig::get('app_pathfiles_folder')."/../actualizacionesaten".'/'.$archivos->getNombre();

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

       $archivo = Doctrine_Core::getTable('Actualizacionesaten')->find(array($request['id']));

      $archivo_nombre = sfConfig::get('app_pathfiles_folder')."/../actualizacionesaten".'/'.$archivo->getImagefile();

      if (file_exists($archivo_nombre)) unlink($archivo_nombre);

      $archivo->delete();

      return true;

  }


  // PASO 1  Procesar Archivo : agrega la informacion a la tabla tmp_pacientes
   public function executeProcesarfile(sfWebRequest $request)
  {
    // Redirige al inicio si no tiene acceso
      if (!$this->getUser()->getGuardUser()->getIsSuperAdmin())
         $this->redirect('ingreso');

      $archivo = Doctrine_Core::getTable('Actualizacionesaten')->find(array($request['id']));
      //$archivo = Doctrine_Core::getTable('Actualizacionesaten')->find(array(5));

      $nombre_archivo = sfConfig::get('app_pathfiles_folder')."/../actualizacionesaten".'/'.$archivo->getImagefile();

      // DATOS conexion
      $dbhost = 'localhost';$dbname = 'circulo';  $dbuser = 'root'; $dbpass = 'root911';

      $sqlTruncate = "TRUNCATE TABLE tmp_atenciones;";

      $sqlLoadInput = "LOAD DATA LOCAL INFILE '".$nombre_archivo."'
         INTO TABLE tmp_atenciones
         CHARACTER SET UTF8
         FIELDS TERMINATED BY ';'
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

      // POR DEFECTO ESTAN TODOS PARA INSERTAR, prepararRegistros marca los que son para actualizar
      Doctrine_Core::getTable('Actualizacionesaten')->prepararRegistros();

      return true;

  }


  // PASO 2 Generar archivo : genera un .sql con las consultas de UPDATE de pacientes
  public function executeGenerarfile(sfWebRequest $request)
  {

    // Variables
    $sqlUpdate='';

    // ESTE MODULO NO HACE NADA

    // Redirige al inicio si no tiene acceso
      if (!$this->getUser()->getGuardUser()->getIsSuperAdmin())
         $this->redirect('ingreso');

      $archivo = Doctrine_Core::getTable('Actualizacionesaten')->find(array($request['id']));
     // $archivo = Doctrine_Core::getTable('Actualizaciones')->find(array(2));

      $arr = explode(".", $archivo->getImagefile(), 2);
      $first = $arr[0];

      $nombre_archivo_upd = sfConfig::get('app_pathfiles_folder')."/../actualizacionesaten".'/upd_'.$first.".sql";

      // DATOS conexion
      /*$dbhost = 'localhost';$dbname = 'circulo';  $dbuser = 'root'; $dbpass = 'root911';

      $pdo = new \PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname, $dbuser, $dbpass, array(
        \PDO::MYSQL_ATTR_LOCAL_INFILE => true
      ));*/


      // PRIMER PASO : ACTUALIZACION DE REGISTROS

      // SI existe el archivo previamente, lo borro
      if (file_exists($nombre_archivo_upd)) unlink($nombre_archivo_upd);

      // NO HAY ACTUALIZACIONES EN ESTE MODULO, ASI QUE NO SE HACE NADA

      fclose ($fp);

      return true;

  }

 // PASO 3, se ejecuta la actualizacion de la tabla pacientes
  public function executeEjecutarfile(sfWebRequest $request)
  {

    // Redirige al inicio si no tiene acceso
      if (!$this->getUser()->getGuardUser()->getIsSuperAdmin())
         $this->redirect('ingreso');

      // INSERTAR NUEVOS PACIENTES
      Doctrine_Core::getTable('Actualizacionesaten')->insertarAtenciones();

      // ACTUALIZAR PACIENTES EXISTENTES
      //exec("/home/projects/circulo/web/Actualizacionesaten/process.sh");

      return true;

  }


  public function executeShow(sfWebRequest $request)
  {
    $this->actualizacionesaten = Doctrine_Core::getTable('Actualizacionesaten')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->actualizacionesaten);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new ActualizacionesatenForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new ActualizacionesatenForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($actualizacionesaten = Doctrine_Core::getTable('Actualizacionesaten')->find(array($request->getParameter('id'))), sprintf('Object actualizacionesaten does not exist (%s).', $request->getParameter('id')));
    $this->form = new ActualizacionesatenForm($actualizacionesaten);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($actualizacionesaten = Doctrine_Core::getTable('Actualizacionesaten')->find(array($request->getParameter('id'))), sprintf('Object actualizacionesaten does not exist (%s).', $request->getParameter('id')));
    $this->form = new ActualizacionesatenForm($actualizacionesaten);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($actualizacionesaten = Doctrine_Core::getTable('Actualizacionesaten')->find(array($request->getParameter('id'))), sprintf('Object actualizacionesaten does not exist (%s).', $request->getParameter('id')));
    $actualizacionesaten->delete();

    $this->redirect('actualizacionesaten/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $actualizacionesaten = $form->save();

      $idorden = intval($request->getPostParameter('$archivos_profesionales[idorden]'));

      if (($idorden<>"") && ($idorden !== NULL) && ($idorden>0)){
            $actualizacionesaten->setIdorden($idorden);
      }


      $folder_path_name = sfConfig::get('app_pathfiles_folder')."/../actualizacionesaten";

      if (!is_dir($folder_path_name) && !mkdir($folder_path_name)){
          die("Error creando carpeta $folder_path_name");
      }

      $hasfile =false;
      foreach ($request->getFiles() as $fileName) {
           $targetFolder = sfConfig::get('app_pathfiles_folder')."/../actualizacionesaten".'/'.$fileName['imagefile']['name'];
           move_uploaded_file($fileName['imagefile']['tmp_name'], $targetFolder);
           $hasfile = true;

      }

      if ($hasfile && trim($fileName['imagefile']['name'])<>'')
         $actualizacionesaten->setImagefile($fileName['imagefile']['name']);


      $actualizacionesaten->save();

      $this->redirect('actualizacionesaten/edit?id='.$actualizacionesaten->getId());
    }
  }

  // ATENCIONES cerradas periodos
  public function executeCerradas(sfWebRequest $request)
  {

    $this->ficheros = array();

    $directorio = sfConfig::get('app_pathfiles_folder')."/../fixperiodos";

    $gestor_dir = opendir($directorio);
    $this->ficheros = array();
    while (false !== ($nombre_fichero = readdir($gestor_dir))) {

      if ($nombre_fichero <> '.' && $nombre_fichero <> '..') {
          $this->ficheros[filemtime($directorio.'/'.$nombre_fichero)] = array($nombre_fichero, $directorio.'/'.$nombre_fichero);
      }

    }
    sort($this->ficheros);

  }

  public function executeNewcerrada(sfWebRequest $request)
  {
    $this->form = new ActualizacionesatencerrForm();
  }
  public function executeCreatecerrada(sfWebRequest $request)
  {
      $folder_path_name = sfConfig::get('app_pathfiles_folder')."/../fixperiodos";

      if (!is_dir($folder_path_name) && !mkdir($folder_path_name)){
          die("Error creando carpeta $folder_path_name");
      }

      $hasfile =false;
      foreach ($request->getFiles() as $fileName) {
             $targetFolder = sfConfig::get('app_pathfiles_folder')."/../fixperiodos".'/'.$fileName['imagefile']['name'];
             move_uploaded_file($fileName['imagefile']['tmp_name'], $targetFolder);
             $hasfile = true;

      }

      $this->redirect('actualizacionesaten/cerradas');
  }

  public function executeUpdatecerrada(sfWebRequest $request)
  {

    $folder_path_name = sfConfig::get('app_pathfiles_folder')."/../fixperiodos";

    if (!is_dir($folder_path_name) && !mkdir($folder_path_name)){
        die("Error creando carpeta $folder_path_name");
    }

    $hasfile =false;
    foreach ($request->getFiles() as $fileName) {
           $targetFolder = sfConfig::get('app_pathfiles_folder')."/../fixperiodos".'/'.$fileName['imagefile']['name'];
           move_uploaded_file($fileName['imagefile']['tmp_name'], $targetFolder);
           $hasfile = true;

    }

    $this->redirect('actualizacionesaten/cerradas');

  }

  public function executeDeletefileperiodo(sfWebRequest $request)
  {
    // Redirige al inicio si no tiene acceso
      if (!$this->getUser()->getGuardUser()->getIsSuperAdmin())
         $this->redirect('ingreso');


      $archivo_nombre = sfConfig::get('app_pathfiles_folder')."/../fixperiodos".'/'.$request['id'];

      if (file_exists($archivo_nombre)) unlink($archivo_nombre);

      return true;

  }


  // PASO 1  Procesar Archivo : agrega la informacion a la tabla tmp_pacientes
   public function executeProcesarfileperiodo(sfWebRequest $request)
  {
    // Redirige al inicio si no tiene acceso
      if (!$this->getUser()->getGuardUser()->getIsSuperAdmin())
         $this->redirect('ingreso');

      $nombre_archivo = sfConfig::get('app_pathfiles_folder')."/../fixperiodos".'/'.$request['id'];

      // DATOS conexion
      $dbhost = 'localhost';$dbname = 'circulo';  $dbuser = 'root'; $dbpass = 'root911';

      $sqlTruncate = "TRUNCATE TABLE tmp_periodos;";

      $sqlLoadInput = "LOAD DATA LOCAL INFILE '".$nombre_archivo."'
         INTO TABLE tmp_periodos
         CHARACTER SET UTF8
         FIELDS TERMINATED BY ';'
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


 // PASO 2, se ejecuta la actualizacion de la tabla pacientes
  public function executeEjecutarfileperiodo(sfWebRequest $request)
  {

    // Redirige al inicio si no tiene acceso
      if (!$this->getUser()->getGuardUser()->getIsSuperAdmin())
         $this->redirect('ingreso');

      // INSERTAR NUEVOS PACIENTES
      Doctrine_Core::getTable('Actualizacionesaten')->actualizarPeriodoCerrado();

      // ACTUALIZAR PACIENTES EXISTENTES
      //exec("/home/projects/circulo/web/Actualizacionesaten/process.sh");

      return true;

  }

}
