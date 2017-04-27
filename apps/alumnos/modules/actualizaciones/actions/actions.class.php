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

      $archivo_nombre = sfConfig::get('app_pathfiles_folder')."/../actualizaciones".'/'.$archivo->getImagefile();
     
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

      $archivo = Doctrine_Core::getTable('Actualizaciones')->find(array($request['id']));
     // $archivo = Doctrine_Core::getTable('Actualizaciones')->find(array(5));

      $nombre_archivo = sfConfig::get('app_pathfiles_folder')."/../actualizaciones".'/'.$archivo->getImagefile();

      // DATOS conexion
      $dbhost = 'localhost';$dbname = 'circulo';  $dbuser = 'root'; $dbpass = 'root911';

      $sqlTruncate = "TRUNCATE TABLE tmp_pacientes;";

      $sqlLoadInput = "LOAD DATA LOCAL INFILE '".$nombre_archivo."'
         INTO TABLE tmp_pacientes 
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
      Doctrine_Core::getTable('Actualizaciones')->prepararRegistros();

      return true;  

  }

  
  // PASO 2 Generar archivo : genera un .sql con las consultas de UPDATE de pacientes
  public function executeGenerarfile(sfWebRequest $request)
  {
    
    // Variables
    $sqlUpdate='';

    // Redirige al inicio si no tiene acceso
      if (!$this->getUser()->getGuardUser()->getIsSuperAdmin())
         $this->redirect('ingreso');
      
      $archivo = Doctrine_Core::getTable('Actualizaciones')->find(array($request['id']));
     // $archivo = Doctrine_Core::getTable('Actualizaciones')->find(array(2));

      $arr = explode(".", $archivo->getImagefile(), 2);
      $first = $arr[0];

      $nombre_archivo_upd = sfConfig::get('app_pathfiles_folder')."/../actualizaciones".'/upd_'.$first.".sql";

      // DATOS conexion
      /*$dbhost = 'localhost';$dbname = 'circulo';  $dbuser = 'root'; $dbpass = 'root911';

      $pdo = new \PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname, $dbuser, $dbpass, array(
        \PDO::MYSQL_ATTR_LOCAL_INFILE => true
      ));*/


      // PRIMER PASO : ACTUALIZACION DE REGISTROS

      // SI existe el archivo previamente, lo borro
      if (file_exists($nombre_archivo_upd)) unlink($nombre_archivo_upd); 

      // CONSULTA por registros a ACTUALIZAR (ya existe el email en la tabla de Pacientes)
      //$datoss =  $archivo = Doctrine_Core::getTable('Actualizaciones')->obtenerRegistrosAActualizar();
      
      $fp=fopen($nombre_archivo_upd,"w+");

      $sqlUpdate = $archivo = Doctrine_Core::getTable('Actualizaciones')->obtenerRegistrosAActualizar('estadocivil','ecivil','N');
      fwrite($fp,$sqlUpdate);

      $sqlUpdate = $archivo = Doctrine_Core::getTable('Actualizaciones')->obtenerRegistrosAActualizar('email','email','T');
      fwrite($fp,$sqlUpdate);

      $sqlUpdate = $archivo = Doctrine_Core::getTable('Actualizaciones')->obtenerRegistrosAActualizar('celular','celular','T');
      fwrite($fp,$sqlUpdate);

      $sqlUpdate = $archivo = Doctrine_Core::getTable('Actualizaciones')->obtenerRegistrosAActualizar('telefono','telefono','T');
      fwrite($fp,$sqlUpdate);

      $sqlUpdate = $archivo = Doctrine_Core::getTable('Actualizaciones')->obtenerRegistrosAActualizar('direccion','direccion','T');
      fwrite($fp,$sqlUpdate);

      $sqlUpdate = $archivo = Doctrine_Core::getTable('Actualizaciones')->obtenerRegistrosAActualizar('idprovincia','codProvincia','N');
      fwrite($fp,$sqlUpdate);

        $sqlUpdate = $archivo = Doctrine_Core::getTable('Actualizaciones')->obtenerRegistrosAActualizar('idciudadnac','codCiudad','N');
      fwrite($fp,$sqlUpdate);

      $sqlUpdate = $archivo = Doctrine_Core::getTable('Actualizaciones')->obtenerRegistrosAActualizar('idobrasocial','codOSocial','N');
      fwrite($fp,$sqlUpdate);

        $sqlUpdate = $archivo = Doctrine_Core::getTable('Actualizaciones')->obtenerRegistrosAActualizar('idplan','codPlan','N');
      fwrite($fp,$sqlUpdate);



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
      Doctrine_Core::getTable('Actualizaciones')->insertarPacientes();  

      // ACTUALIZAR PACIENTES EXISTENTES
      exec("/home/projects/circulo/web/actualizaciones/process.sh");

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

  public function executeViejoGenerarfile(sfWebRequest $request)
  {
    
    // Variables
    $sqlInsert = ''; $sqlUpdate='';

    // Redirige al inicio si no tiene acceso
      if (!$this->getUser()->getGuardUser()->getIsSuperAdmin())
         $this->redirect('ingreso');

      $archivo = Doctrine_Core::getTable('Actualizaciones')->find(array($request['id']));
     // $archivo = Doctrine_Core::getTable('Actualizaciones')->find(array(2));

      $arr = explode(".", $archivo->getImagefile(), 2);
      $first = $arr[0];

      $nombre_archivo_ins = sfConfig::get('app_pathfiles_folder')."/../actualizaciones".'/ins_'.$first.".sql";
      $nombre_archivo_upd = sfConfig::get('app_pathfiles_folder')."/../actualizaciones".'/upd_'.$first.".sql";

      // DATOS conexion
      $dbhost = 'localhost';$dbname = 'circulo';  $dbuser = 'root'; $dbpass = 'root911';

      $pdo = new \PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname, $dbuser, $dbpass, array(
        \PDO::MYSQL_ATTR_LOCAL_INFILE => true
      ));


      // PRIMER PASO : ACTUALIZACION DE REGISTROS

      // SI existe el archivo previamente, lo borro
      if (file_exists($nombre_archivo_upd)) unlink($nombre_archivo_upd); 

      // CONSULTA por registros a ACTUALIZAR (ya existe el email en la tabla de Pacientes)
      $datoss =  $archivo = Doctrine_Core::getTable('Actualizaciones')->obtenerRegistrosAActualizar();
      
      $fp=fopen($nombre_archivo_upd,"w+");
    
      foreach($datoss as $dato){

            $sqlUpdate = "UPDATE `pacientes` SET nombre = '".$dato['nombre']."', apellido = '".$dato['apellido']."',idsexo = '".$dato['sexo']."',nrodoc = '".$dato['documento']."', fechanac='".$dato['fechanac']."',idciudadnac ='".$dato['codCiudad']."',estadocivil='".$dato['ecivil']."',celular='".$dato['celular']."',telefono='".$dato['telefono']."',direccion='".$dato['direccion']."',titular='".$dato['titular']."',parentesco='".$dato['parentesco']."',trabajo='".$dato['trabajo']."',jerarquia='".$dato['jerarquia']."',anotaciones='".$dato['anotaciones']."',nroafiliado='".$dato['nroafiliado']."',historial='".$dato['historial']."',idprovincia='".$dato['codProvincia']."',idobrasocial='".$dato['codOSocial']."',idplan='".$dato['codPlan']."',updated_at =NOW(),idtipoiva='".$dato['idtipoiva']."'  WHERE email='".$dato['email']."';";

            fwrite($fp,$sqlUpdate);
          
      }
      fclose ($fp);
      
      

     // SEGUNDO PASO : insercion de nuevos registros

       // SI existe el archivo previamente, lo borro
      if (file_exists($nombre_archivo_ins)) unlink($nombre_archivo_ins); 
 
      // CONSULTA por registros a INSERTAR (no está el email en la tabla de Pacientes)
      $datoss =  $archivo = Doctrine_Core::getTable('Actualizaciones')->obtenerRegistrosAInsertar();
      
      $fp=fopen($nombre_archivo_ins,"w+");
    
      foreach($datoss as $dato){

            $sqlInsert = "INSERT INTO `pacientes` VALUES (NULL,'".$dato['nombre']."','".$dato['apellido']."','".$dato['sexo']."','".$dato['documento']."','".$dato['fechanac']."','".$dato['fechanac']."','".$dato['codCiudad']."','".$dato['ecivil']."','".$dato['email']."','".$dato['celular']."','".$dato['telefono']."','".$dato['direccion']."','".$dato['titular']."','".$dato['parentesco']."','','','".$dato['trabajo']."','".$dato['jerarquia']."','','".$dato['anotaciones']."','1','".$dato['nroafiliado']."','".$dato['historial']."','','".$dato['codProvincia']."','".$dato['codOSocial']."','".$dato['codPlan']."',NOW(), NOW(),1,1,'".$dato['idtipoiva']."');";

            fwrite($fp,$sqlInsert);
          
      }
      fclose ($fp);

      return true;  

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
