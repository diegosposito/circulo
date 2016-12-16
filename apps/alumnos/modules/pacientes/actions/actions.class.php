<?php

/**
 * pacientes actions.
 *
 * @package    sig
 * @subpackage pacientes
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class pacientesActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->criterio = '';
    $this->pacientess = Doctrine_Core::getTable('Pacientes')
      ->createQuery('a')
      ->limit(200)
      ->execute();

    if ($request->isMethod(sfRequest::POST) && $request->getParameter('idbuscarname')<>''){
      
      $this->pacientess = Doctrine_Core::getTable('Pacientes')
      ->createQuery('a')
      ->where('a.apellido  like "%'.$request->getParameter('idbuscarname').'%"')
      ->execute();

      $this->criterio = $request->getParameter('idbuscarname');

    }  

  }

  public function executeGuardarinformacionpersonal(sfWebRequest $request) {
      
      $numerodoc = $request->getParameter('nrodoc');
      $nrodoc = preg_replace("/[^\d]/", "", $numerodoc);    
    
      $arr = explode('-', $request->getParameter('fechanac'));
      $fechanacimiento = $arr[2]."-".$arr[1]."-".$arr[0];

      $paciente = Doctrine::getTable('Pacientes')->getPacienteIdByNroDoc($request->getParameter('nrodoc'));
      
      if ($idpaciente<>''){
         $oPaciente = Doctrine::getTable('Pacientes')->find($paciente->getId());
      } else {
        $oPaciente = new Pacientes();
        $oPaciente->setIdtipodoc($request->getParameter('idtipodocumento'));
        $oPaciente->setFechanac($fechanacimiento);
        $oPaciente->setNrodoc($nrodoc);
      }
      // Guarda los datos personales
      $oPaciente->setNrodoc($numerodoc);      
      $oPaciente->setNombre(ucwords(strtolower($request->getParameter('nombre'))));
      $oPaciente->setApellido(strtoupper($request->getParameter('apellido')));
      $oPaciente->setIdsexo($request->getParameter('idsexo'));
      $oPaciente->setEstadocivil($request->getParameter('estadocivil'));
      $oPaciente->setIdciudadnac($request->getParameter('ciudadnacimiento'));
      $oPaciente->setFechanac($fechanacimiento);
      $oPersona->save();    

      echo json_encode(array("idpaciente"=>$oPaciente->getId(),"mensaje"=>"El Paciente ha sido guardado correctamente."));

    return sfView::NONE;
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->pacientes = Doctrine_Core::getTable('Pacientes')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->pacientes);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new PacientesForm();
  }

  public function executeNuevo(sfWebRequest $request)
  {
    $this->form = new PacientesForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new PacientesForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($pacientes = Doctrine_Core::getTable('Pacientes')->find(array($request->getParameter('id'))), sprintf('Object pacientes does not exist (%s).', $request->getParameter('id')));
    $this->form = new PacientesForm($pacientes);
    $this->forward404Unless($this->paciente = Doctrine_Core::getTable('Pacientes')->find(array($request->getParameter('id'))), sprintf('Object pacientes does not exist (%s).', $request->getParameter('id')));
    
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($pacientes = Doctrine_Core::getTable('Pacientes')->find(array($request->getParameter('id'))), sprintf('Object pacientes does not exist (%s).', $request->getParameter('id')));
    $this->form = new PacientesForm($pacientes);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($pacientes = Doctrine_Core::getTable('Pacientes')->find(array($request->getParameter('id'))), sprintf('Object pacientes does not exist (%s).', $request->getParameter('id')));
    $pacientes->delete();

    $this->redirect('pacientes/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $pacientes = $form->save();

      $folder_path_name = sfConfig::get('app_pathfiles_folder')."/pacientes/".$pacientes->getId();
      
      if (!is_dir($folder_path_name) && !mkdir($folder_path_name)){
          die("Error creando carpeta $uploaddir");
      }

      $hasfile =false;
      foreach ($request->getFiles() as $fileName) {

           if (trim($fileName['imagefile']['name'])<>'') {
              $targetFolder = sfConfig::get('app_pathfiles_folder')."/pacientes/".$pacientes->getId().'/'.$fileName['imagefile']['name'];
              move_uploaded_file($fileName['imagefile']['tmp_name'], $targetFolder);
              $pacientes->setImagefile($fileName['imagefile']['name']);
           }   

           if (trim($fileName['credencial']['name'])<>'') {
              $targetFolder = sfConfig::get('app_pathfiles_folder')."/pacientes/".$pacientes->getId().'/'.$fileName['credencial']['name'];
              move_uploaded_file($fileName['credencial']['tmp_name'], $targetFolder);
              $pacientes->setCredencial($fileName['credencial']['name']); 
           }  
     
      } 
    
      $pacientes->save();

      $this->redirect('pacientes/edit?id='.$pacientes->getId());
    }
  }
}
