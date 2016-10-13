<?php

/**
 * ingreso actions.
 *
 * @package    sig
 * @subpackage ingreso
 * @author     Your name here
 * @version    
 */
class ingresoActions extends sfActions
{		
  public function executeIndex(sfWebRequest $request)
  {
      $this->noticiass = Doctrine_Core::getTable('Noticia')
      ->createQuery('n')
      ->where('n.visible')
      ->orderBy('n.idorden')
      ->execute();	
  } 

  public function executeHistoria(sfWebRequest $request)
  {
  
  }

  public function executeSaludent(sfWebRequest $request)
  {
  
  } 

  public function executeUbicacion(sfWebRequest $request)
  {
  
  }

  public function executeContacto(sfWebRequest $request)
  {
  
  } 
  
  public function executeIndexfacultad(sfWebRequest $request)
  {
  	//obtengo datos del usuario
	$this->usuario=$this->getUser()->getUsername();
	$this->idarea = 1;
	$oAreas = Doctrine::getTable('Areas')->find($this->idarea);
	$this->area= $oAreas->getDescripcion();
  }  
  
  public function executeError(sfWebRequest $request)
  {
    $this->msgerror = $request->getParameter('msgerror');
  }
}
