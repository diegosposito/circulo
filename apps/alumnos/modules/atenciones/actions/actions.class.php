<?php

/**
 * atenciones actions.
 *
 * @package    sig
 * @subpackage atenciones
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class atencionesActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->criterio = '';
    $f_apellido = NULL; $f_nrodoc = NULL;

    if ( $request->getParameter('idbuscarname')<>''){

      if ( $request->getParameter('idtipobusqueda')==1)
        $f_apellido = $request->getParameter('idbuscarname');

      if ( $request->getParameter('idtipobusqueda')==2)
          $f_nrodoc = $request->getParameter('idbuscarname');
    }

    $this->pacientess = Doctrine_Core::getTable('Pacientes')->obtenerPacientes($f_apellido,NULL, $f_nrodoc, 300);

    $this->criterio = $request->getParameter('idbuscarname');
    $this->idtipobusqueda = $request->getParameter('idtipobusqueda');

  }

  public function executeEditar(sfWebRequest $request)
  {
     // PRIMER TAB - Obtener paciente seleccionado
    $this->forward404Unless($pacientes = Doctrine_Core::getTable('Pacientes')->find(array($request->getParameter('id'))), sprintf('Object pacientes does not exist (%s).', $request->getParameter('id')));
    $this->form = new PacientesForm($pacientes);
    $this->paciente = $pacientes;

    if($request->getParameter('selectedtab')>0)
        $this->selectedtab = $request->getParameter('selectedtab');
     else {
        $this->selectedtab = '1';
     }

     // SEGUNDO TAB - Obtener pacientes segun filtro
     $this->criterio = '';
     $f_apellido = NULL; $f_idobrasocial = NULL;

     if ( $request->getParameter('idbuscarname')<>'')
       $f_apellido = $request->getParameter('idbuscarname');

     if ( $request->getParameter('idobrasocial')>0)
       $f_idobrasocial = $request->getParameter('idobrasocial');

     $this->atencioness = Doctrine_Core::getTable('Atenciones')->obtenerAtencionesPorPaciente($request->getParameter('id'));

     if ($request->getParameter('idatencion')>0){
       $this->forward404Unless($atencion = Doctrine_Core::getTable('Atenciones')->find(array($request->getParameter('idatencion'))), sprintf('Object atenciones does not exist (%s).', $request->getParameter('id')));
       $this->formatenciones = new AtencionesForm($atencion);
     }


     // TERCER TAB
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->atenciones = Doctrine_Core::getTable('Atenciones')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->atenciones);
  }

  public function executeMasivas(sfWebRequest $request)
  {

    $this->archivos_profesionaless = Doctrine_Core::getTable('Actualizacionestrat')
      ->createQuery('a')
      ->orderby(nombre)
      ->execute();

    $this->ficheros = array();

    foreach($this->archivos_profesionaless as $archivos){
        $targetFolder = sfConfig::get('app_pathfiles_folder')."/../actualizacionestrat".'/'.$archivos->getNombre();

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

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new AtencionesForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new AtencionesForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($this->atenciones = Doctrine_Core::getTable('Atenciones')->find(array($request->getParameter('id'))), sprintf('Object atenciones does not exist (%s).', $request->getParameter('id')));
    $this->form = new AtencionesForm($this->atenciones);
    $this->idpaciente = $request->getParameter('idpaciente');
    $this->forward404Unless($paciente = Doctrine_Core::getTable('Pacientes')->find(array($request->getParameter('idpaciente'))), sprintf('Object pacientes does not exist (%s).', $request->getParameter('id')));
    $this->paciente = $paciente;

    // Obtener usuario logueado
    $user_id = $this->getUser()->getGuardUser()->getId();
    $persona = Doctrine_Core::getTable('Personas')->obtenerProfesionalxUser($user_id);
    $matricula = $persona[0]['matricula'];

  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($atenciones = Doctrine_Core::getTable('Atenciones')->find(array($request->getParameter('id'))), sprintf('Object atenciones does not exist (%s).', $request->getParameter('id')));

    $atenciones->setMes($request->getPostParameter('atenciones[mes]'));
    $atenciones->setImporte($request->getPostParameter('atenciones[importe]'));
    $atenciones->setCaras($request->getPostParameter('atenciones[caras]'));
    $atenciones->setPieza($request->getPostParameter('atenciones[pieza]'));
    $fecha = $request->getPostParameter('atenciones[fecha][year]').'-'.$request->getPostParameter('atenciones[fecha][month]').'-'.$request->getPostParameter('atenciones[fecha][day]');
    $atenciones->setFecha($fecha);
    $atenciones->setIdAutorizacion($request->getPostParameter('atenciones[idautorizacion]'));
    $atenciones->setAnotacion($request->getPostParameter('atenciones[anotacion]'));
    if ($request->getPostParameter('atenciones[autorizada]') == 'on') {
      $atenciones->setAutorizada(1);
    } else {
      $atenciones->setAutorizada(0);
    }
    $atenciones->save();

    $this->redirect('atenciones/editar?id='.$request->getParameter('idpaciente'));


    /*$this->form = new AtencionesForm($atenciones);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit'); */
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($atenciones = Doctrine_Core::getTable('Atenciones')->find(array($request->getParameter('id'))), sprintf('Object atenciones does not exist (%s).', $request->getParameter('id')));
    $atenciones->delete();

    $this->redirect('atenciones/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $atenciones = $form->save();

      $this->redirect('atenciones/edit?id='.$atenciones->getId());
    }
  }
}
