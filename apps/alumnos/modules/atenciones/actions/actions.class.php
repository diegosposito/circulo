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

    $this->pacientess = Doctrine_Core::getTable('Pacientes')->obtenerPacientes($f_apellido,NULL, $f_nrodoc, 1, 300);

    $this->criterio = $request->getParameter('idbuscarname');
    $this->idtipobusqueda = $request->getParameter('idtipobusqueda');

  }

    /** Actual month last day **/
  public function data_last_month_day() {
      $month = date('m');
      $year = date('Y');
      $day = date("d", mktime(0,0,0, $month+1, 0, $year));

      return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
  }

  /** Actual month first day **/
  public function data_first_month_day() {
      $month = date('m');
      $year = date('Y');
      return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
  }

  public function ultimo_dia_del_mes() {
      $month = date('m');
      $year = date('Y');
      $day = date("d", mktime(0,0,0, $month+1, 0, $year));

      return date('d', mktime(0,0,0, $month, $day, $year));
  }

  public function executeCerrar(sfWebRequest $request)
  {

    /*$aniohasta = date ("Y");
    $aniodesde = $aniohasta - 25;

    $this->aAnios = array();
    $this->aMeses = array();*/
    $this->periodo = '';
    $this->mostrar_boton_cerrar =false;

    // Obtener usuario logueado
    $user_id = $this->getUser()->getGuardUser()->getId();
    $persona = Doctrine_Core::getTable('Personas')->obtenerProfesionalxUser($user_id);
    $matricula = $persona[0]['matricula'];
    $this->atencioness = Doctrine_Core::getTable('Atenciones')->obtenerAtencionesAbiertasPorProfesional($matricula);

    $fechaactual = date('Y-m-j');
    $fechaanterior = strtotime ( '-1 month' , strtotime ( $fechaactual ) ) ;

    // si es primer o segundo dia muestra periodo del mes anterior
    if (date('j')==1 OR date('j')==2){
        $this->periodo = date ( 'Y-m' , $fechaanterior );
        $this->mostrar_boton_cerrar = true;
    } else { // sino analiza si es ultimo o ante ultimo dia del mes
        $ultimo_dia = $this->ultimo_dia_del_mes();
        $anterior_ultimo_dia = $ultimo_dia - 1;
        if (date('j')==$ultimo_dia OR date('j')==$anterior_ultimo_dia){
           $this->periodo = date('Y-m');
           $this->mostrar_boton_cerrar = true;
        }
    }


   /* for( $i= $aniohasta ; $i >= $aniodesde ; $i-- )
    {
      $this->aAnios[$i] =  $i;
    }

    $mes = '';

    for( $i= 1 ; $i <= 12 ; $i++ )
    {
        switch($i) {
          case 1:
          $mes = 'Enero';
          break;

          case 2:
          $mes = 'Febrero';
          break;

          case 3:
          $mes = 'Marzo';
          break;

          case 4:
          $mes = 'abril';
          break;

          case 5:
          $mes = 'Mayo';
          break;

          case 6:
          $mes = 'Junio';
          break;

          case 7:
          $mes = 'Julio';
          break;

          case 8:
          $mes = 'Agosto';
          break;

          case 9:
          $mes = 'Septiembre';
          break;

          case 10:
          $mes = 'Octubre';
          break;

          case 11:
          $mes = 'Noviembre';
          break;

          case 12:
          $mes = 'Diciembre';
          break;

          default:

          $mes = 'Enero';

          }

          $this->aMeses[$i] =  $mes;
    }

    $this->criterio = '';
    $f_apellido = NULL; $f_nrodoc = NULL;

    if ( $request->getParameter('idAnio')<>'' && $request->getParameter('idMes')<>''){

      $this->atencioness = Doctrine_Core::getTable('Atenciones')->obtenerAtencionesPorProfesionalPeriodo($matricula, $request->getParameter('idMes'), $request->getParameter('idAnio'));

    }

    $this->idAnio = $request->getParameter('idAnio');
    $this->idMes = $request->getParameter('idMes');*/

  }

  public function executeCerrarperiodo(sfWebRequest $request)
  {

    // Obtiene atenciones seleccionadoas para no cerrar
    $idcase = $request->getParameter('idcase', '');
    $periodo = $request->getParameter('periodo');
    // $arr[0]  es año, $arr[1] es mes
    $arr = explode('-', $periodo);
    $arr_asignaciones = array();

    // Obtener usuario logueado
    $user_id = $this->getUser()->getGuardUser()->getId();
    $persona = Doctrine_Core::getTable('Personas')->obtenerProfesionalxUser($user_id);
    $matricula = $persona[0]['matricula'];

    foreach($idcase as $seleccionados){
      if(is_numeric($seleccionados))
          $arr_asignaciones[] = $seleccionados;
    }

    // Se cierran las atenciones seleccionadas
    if ( count($arr_asignaciones)>0 ){
        Doctrine_Core::getTable('Atenciones')->cerrarAtencionesPorProfesionalPeriodo($matricula, $arr[1], $arr[0], $arr_asignaciones);
        $this->mensaje = 'Período cerrado exitosamente :  '.$arr[1].'/'.$arr[0];
    } else {
        Doctrine_Core::getTable('Atenciones')->cerrarAtencionesPorProfesionalPeriodo($matricula, $arr[1], $arr[0]);
        $this->mensaje = 'Período cerrado exitosamente :  '.$arr[1].'/'.$arr[0];
    }

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

    $atencion = new Atenciones();
    $this->form = new AtencionesForm($atencion, array('idpaciente' => $request->getParameter('idpaciente')));

    $this->idpaciente = $request->getParameter('idpaciente');
    $this->forward404Unless($paciente = Doctrine_Core::getTable('Pacientes')->find(array($request->getParameter('idpaciente'))), sprintf('Object pacientes does not exist (%s).', $request->getParameter('id')));
    $this->paciente = $paciente;
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->forward404Unless($paciente = Doctrine_Core::getTable('Pacientes')->find(array($request->getParameter('idpaciente'))), sprintf('Object pacientes does not exist (%s).', $request->getParameter('id')));
    $this->forward404Unless($tratamiento = Doctrine_Core::getTable('Tratamientos')->find(array($request->getPostParameter('atenciones[idtratamiento]'))), sprintf('Object pacientes does not exist (%s).', $request->getPostParameter('atenciones[idtratamiento]')));

    // Obtener usuario logueado
    $user_id = $this->getUser()->getGuardUser()->getId();
    $persona = Doctrine_Core::getTable('Personas')->obtenerProfesionalxUser($user_id);
    $matricula = $persona[0]['matricula'];

    $atenciones = new Atenciones();
    $atenciones->setNrodoc($paciente->getNrodoc());
    $atenciones->setMatricula($matricula);
    $atenciones->setIdobrasocial($paciente->getIdobrasocial());
    $atenciones->setIdtratamiento($tratamiento->getId());
    $atenciones->setTratamiento($tratamiento->getNombre());
    $atenciones->setMes($request->getPostParameter('atenciones[mes]'));
    $atenciones->setAnio($request->getPostParameter('atenciones[anio]'));
    $atenciones->setImporte($request->getPostParameter('atenciones[importe]'));
    $atenciones->setCoseguro($request->getPostParameter('atenciones[coseguro]'));
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

    //$this->redirect('atenciones/editar?id='.$request->getParameter('idpaciente'));
    return sfView::NONE;

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
    $atenciones->setAnio($request->getPostParameter('atenciones[anio]'));
    //$atenciones->setImporte($request->getPostParameter('atenciones[importe]'));
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
