<?php

/**
 * BaseUnidadesDeTiempo
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idunidadtiempo
 * @property string $descripcion
 * 
 * @method integer          getIdunidadtiempo() Returns the current record's "idunidadtiempo" value
 * @method string           getDescripcion()    Returns the current record's "descripcion" value
 * @method UnidadesDeTiempo setIdunidadtiempo() Sets the current record's "idunidadtiempo" value
 * @method UnidadesDeTiempo setDescripcion()    Sets the current record's "descripcion" value
 * 
 * @package    sig
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseUnidadesDeTiempo extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('unidades_de_tiempo');
        $this->hasColumn('idunidadtiempo', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('descripcion', 'string', 50, array(
             'type' => 'string',
             'primary' => false,
             'notnull' => true,
             'default' => '',
             'length' => 50,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $timestampable0 = new Doctrine_Template_Timestampable();
        $fzblameable0 = new Doctrine_Template_fzblameable();
        $this->actAs($timestampable0);
        $this->actAs($fzblameable0);
    }
}