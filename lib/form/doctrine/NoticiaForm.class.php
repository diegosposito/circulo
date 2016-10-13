<?php

/**
 * Noticia form.
 *
 * @package    sig
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class NoticiaForm extends BaseNoticiaForm
{
  public function configure()
  {
  	  unset( $this['created_at'], $this['updated_at'], $this['created_by'], $this['updated_by'] );
     
      // Se define los labels
	    $this->widgetSchema->setLabel('titulo', '<p align="left">Título:</p>');
 	    $this->widgetSchema->setLabel('descripcion', '<p align="left">Noticia:</p>');
      $this->widgetSchema->setLabel('copete', '<p align="left">Copete:</p>');
 	    $this->widgetSchema->setLabel('idtiponoticia', '<p align="left">Categoría de Noticia:</p>');
      $this->widgetSchema->setLabel('visible', '<p align="left">Visible:</p>');
      $this->widgetSchema->setLabel('idorden', '<p align="left">Orden:</p>');
      $this->widgetSchema->setLabel('imagefile', '<p align="left">Imágen:</p>');

     

      $arregloCategorias = array('1' => 'General', '2' => 'Para Profesional');

      $this->widgetSchema['imagefile'] = new sfWidgetFormInputFile(array(
                                               'label' => 'Imagen de Noticia',
                                             ));

      $this->widgetSchema['descripcion'] = new sfWidgetFormTextareaTinyMCE(
        array(
          'config' => sfConfig::get('app_tiny_mce_simple')
        )
      );

      $this->widgetSchema['titulo'] = new sfWidgetFormInputText(array(), array("style"=>'width: 365px;'));

     
      $this->widgetSchema->setLabel('imagefile', '<p align="left">Imagen de Noticia:</p>');
    
      $this->widgetSchema['idtiponoticia'] = new sfWidgetFormSelect(array('label' => '<p align="left"><b>Categoría de Noticia:</b></p>', 'choices' => $arregloCategorias));
  

      $this->setValidators(array(
        'titulo' => new sfValidatorString(array('required' => true), array('required' => 'El título es obligatorio.')),
        'descripcion' => new sfValidatorString(array('required' => true), array('required' => 'La noticia es obligatoria.')),
        'copete' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
        'idtiponoticia'    => new sfValidatorInteger(array('required' => false)),
        'idorden'    => new sfValidatorInteger(array('required' => false)),
        'imagefile' => new sfValidatorFile(array('required' => false)),
        ));

      $this->validatorSchema->setOption('allow_extra_fields',true); 
  }
}
