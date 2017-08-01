<?php

/**
 * obrassociales actions.
 *
 * @package    sig
 * @subpackage obrassociales
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class obrassocialesActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->obras_socialess = Doctrine_Core::getTable('ObrasSociales')
      ->createQuery('a')
      ->orderBy('a.ninterno')
      ->execute();
  }

  public function executeObtenerplanes(sfWebRequest $request)
  {
    $os = Doctrine_Core::getTable('ObrasSociales')->find($request->getParameter('idobrasocial'));
    $this->planes = $os->obtenerPlanes();
    $this->idplan = $request->getParameter('idplan');
  }

  public function executeObtenertratamientos(sfWebRequest $request)
  {
    $this->tratamientos = Doctrine_Core::getTable('Tratamientos')->obtenerPorObraSocial($request->getParameter('idobrasocial'), 1);
  }

  public function executeObtenerinfo(sfWebRequest $request)
  {
    //echo $request->getParameter('idobrasocial');
    $this->oss = Doctrine_Core::getTable('ObrasSociales')->find(array($request->getParameter('idobrasocial')));
  }

   public function executeObtenerformato(sfWebRequest $request)
  {
    //echo $request->getParameter('idobrasocial');
    $this->oss = Doctrine_Core::getTable('ObrasSociales')->find(array($request->getParameter('idobrasocial')));
  }

  public function executeMostrar(sfWebRequest $request)
  {
    $this->obras_sociales = Doctrine_Core::getTable('ObrasSociales')->find(array($request->getParameter('idobrasocial')));
   // $this->obras_sociales = Doctrine_Core::getTable('ObrasSociales')->find(array(1));
    $this->forward404Unless($this->obras_sociales);

    if(count($_FILES['upload']['name']) > 0){
        //Loop through each file
        for($i=0; $i<count($_FILES['upload']['name']); $i++) {
          //Get the temp file path
            $tmpFilePath = $_FILES['upload']['tmp_name'][$i];



            //Make sure we have a filepath
            if($tmpFilePath != ""){

                //save the filename
                $shortname = $_FILES['upload']['name'][$i];

                //save the url and the file
                //$filePath = "/tmp/uploaded/" . date('d-m-Y-H-i-s').'-'.$_FILES['upload']['name'][$i];
               // $filePath = sfConfig::get('app_pathfiles_folder')."/".$obras_sociales->getIdobrasocial();
                $filePath = sfConfig::get('app_pathfiles_folder')."/".$this->obras_sociales->getIdObrasocial()."/".$shortname;

                //Upload the file into the temp dir
                if(move_uploaded_file($tmpFilePath, $filePath)) {

                    $files[] = $shortname;
                    //insert into db
                    //use $shortname for the filename
                    //use $filePath for the relative url to the file

                }
            }// endif
        } // endfor
    } // end if

    // listar archivos de la carpeta
    $directorio = sfConfig::get('app_pathfiles_folder')."/".$this->obras_sociales->getIdObrasocial();
    $gestor_dir = opendir($directorio);
    $this->ficheros = array();
    while (false !== ($nombre_fichero = readdir($gestor_dir))) {

      $image_file = 'image.png';
      switch (pathinfo($nombre_fichero, PATHINFO_EXTENSION)) {
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
      }

      if ($nombre_fichero <> '.' && $nombre_fichero <> '..') {
          $this->ficheros[filemtime($directorio.'/'.$nombre_fichero)] = array($nombre_fichero, $this->obras_sociales->getIdObrasocial()."/".$nombre_fichero, $image_file);
      }
    }
    krsort($this->ficheros);

  } // end function


  public function executeShow(sfWebRequest $request)
  {
    $this->obras_sociales = Doctrine_Core::getTable('ObrasSociales')->find(array($request->getParameter('idobrasocial')));
    $this->forward404Unless($this->obras_sociales);
  }

  public function executeNew(sfWebRequest $request)
  {
    // Redirige al inicio si no tiene acceso
    if($this->getUser())
    if (!$this->getUser()->getGuardUser()->getIsSuperAdmin())
      $this->redirect('ingreso');

     $this->form = new ObrasSocialesForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new ObrasSocialesForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
      // Redirige al inicio si no tiene acceso
      if (!$this->getUser()->getGuardUser()->getIsSuperAdmin())
         $this->redirect('ingreso');

      $this->forward404Unless($obras_sociales = Doctrine_Core::getTable('ObrasSociales')->find(array($request->getParameter('idobrasocial'))), sprintf('Object obras_sociales does not exist (%s).', $request->getParameter('idobrasocial')));
      $this->form = new ObrasSocialesForm($obras_sociales);
  }

  public function executeImpresion(sfWebRequest $request){

         // Redirige al inicio si no tiene acceso
      if (!$this->getUser()->getGuardUser()->getIsSuperAdmin())
         $this->redirect('ingreso');

      $obras_sociales = Doctrine_Core::getTable('ObrasSociales')->obtenerObrasSociales();


      $pdf = new PDF();

$pdf->SetFont("Times", "", 9);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();
$current_date = date("Y");
$encabezado = '
      <div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
      style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/alcec3.jpg" width="550px">
      Generar recibos: '.$current_date.'</div>';

$pdf->writeHTML($encabezado, true, false, true, false, '');

$y = 60;
$pdf->SetXY(10,$y);
$pdf->Cell(10,5,'Obra Social',0,0,'C');
$pdf->SetXY(20,$y);
$pdf->Cell(80,5,'Abrev.',0,0,'C');
$pdf->SetXY(20,$y);
$pdf->Cell(225,5,'Fecha1',0,0,'C');
$pdf->SetXY(20,$y);
$pdf->Cell(280,5,'Fecha2',0,0,'C');
$pdf->SetXY(20,$y);
$y = $y + 5;
$contador = 1;

$pdf->Line(10,$y,199,$y);

    foreach ($obras_sociales as $osocial){

        $pdf->SetXY(0,$y-5);
        $pdf->SetXY(10,$y);
        $pdf->Cell(10,5,$osocial['idobrasocial'],0,0,'L');
        $pdf->SetXY(20,$y);
        $pdf->Cell(80,5,$osocial['idobrasocial'],0,0,'L');
        $pdf->SetXY(120,$y);
        $pdf->Cell(10,5,$osocial['idobrasocial'],0,0,'L');
        $pdf->SetXY(160,$y);
        $pdf->Cell(10,5,$osocial['idobrasocial'],0,0,'L');

        $y = $y + 5;
        // add a page
        if($y>=265) {
            $pdf->AddPage();

            $encabezado = '
              <div style="text-align: center; font-family: Times New Roman,Times,serif;"><span
              style="font-size: 12;"><img src="'.$request->getRelativeUrlRoot().'/images/alcec3.jpg" width="550px">Generar Recibos: '.$current_date.'</div>';

            $pdf->writeHTML($encabezado, true, false, true, false, '');
            $y=60;
         }

      } // fin (foreach)


     $pdf->Output('recibos.pdf', 'I');

     return sfView::NONE;
  }


  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($obras_sociales = Doctrine_Core::getTable('ObrasSociales')->find(array($request->getParameter('idobrasocial'))), sprintf('Object obras_sociales does not exist (%s).', $request->getParameter('idobrasocial')));
    $this->form = new ObrasSocialesForm($obras_sociales);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
         // Redirige al inicio si no tiene acceso
      if (!$this->getUser()->getGuardUser()->getIsSuperAdmin())
         $this->redirect('ingreso');

    $request->checkCSRFProtection();

    $this->forward404Unless($obras_sociales = Doctrine_Core::getTable('ObrasSociales')->find(array($request->getParameter('idobrasocial'))), sprintf('Object obras_sociales does not exist (%s).', $request->getParameter('idobrasocial')));
    $obras_sociales->delete();

    $this->redirect('obrassociales/index');
  }

  public function executeDeletefile(sfWebRequest $request)
  {
    // Redirige al inicio si no tiene acceso
      if (!$this->getUser()->getGuardUser()->getIsSuperAdmin())
         $this->redirect('ingreso');

      $filePath = sfConfig::get('app_pathfiles_folder')."/".$request['nombrearchivo'];

      unlink($filePath);

      return sfView::NONE;

  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $obras_sociales = $form->save();

      $obras_sociales->setFechaarancel($request->getPostParameter('obras_sociales[fechaarancel][year]').'-'.$request->getPostParameter('obras_sociales[fechaarancel][month]').'-'.$request->getPostParameter('obras_sociales[fechaarancel][day]'));
      $obras_sociales->setFechaultimoperiodo($request->getPostParameter('obras_sociales[fechaultimoperiodo][year]').'-'.$request->getPostParameter('obras_sociales[fechaultimoperiodo][month]').'-'.$request->getPostParameter('obras_sociales[fechaultimoperiodo][day]'));


      $obras_sociales->setNinterno($request->getPostParameter('obras_sociales[ninterno]'));

      if ($request->getPostParameter('obras_sociales[general]') == 'on') {
        $obras_sociales->setGeneral(1);
      } else {
        $obras_sociales->setGeneral(0);
      }

      if ($request->getPostParameter('obras_sociales[protesis]') == 'on') {
        $obras_sociales->setProtesis(1);
      } else {
        $obras_sociales->setProtesis(0);
      }

      if ($request->getPostParameter('obras_sociales[ortodoncia]') == 'on') {
        $obras_sociales->setOrtodoncia(1);
      } else {
        $obras_sociales->setOrtodoncia(0);
      }

      if ($request->getPostParameter('obras_sociales[implantes]') == 'on') {
        $obras_sociales->setImplantes(1);
      } else {
        $obras_sociales->setImplantes(0);
      }

      $obras_sociales->save();

      $folder_path_name = sfConfig::get('app_pathfiles_folder')."/".$obras_sociales->getIdobrasocial();

      if (!is_dir($folder_path_name) && !mkdir($folder_path_name)){
          die("Error creating folder $uploaddir");
      }

      $this->redirect('obrassociales/edit?idobrasocial='.$obras_sociales->getIdobrasocial());
    }
  }
}
