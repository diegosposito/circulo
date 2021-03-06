<?php

/**
 * BaseTiposCursadas
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idtipocursada
 * @property string $descripcion
 * @property Doctrine_Collection $TiposCursadas
 * 
 * @method integer             getIdtipocursada() Returns the current record's "idtipocursada" value
 * @method string              getDescripcion()   Returns the current record's "descripcion" value
 * @method Doctrine_Collection getTiposCursadas() Returns the current record's "TiposCursadas" collection
 * @method TiposCursadas       setIdtipocursada() Sets the current record's "idtipocursada" value
 * @method TiposCursadas       setDescripcion()   Sets the current record's "descripcion" value
 * @method TiposCursadas       setTiposCursadas() Sets the current record's "TiposCursadas" collection
 * 
 * @package    sig
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTiposCursadas extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('tipos_cursadas');
        $this->hasColumn('idtipocursada', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('descripcion', 'string', 50, array(
             'type' => 'string',
             'notnull' => true,
             'default' => '',
             'length' => 50,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('MateriasPlanes as TiposCursadas', array(
             'local' => 'idtipocursada',
             'foreign' => 'idtipocursada'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $fzblameable0 = new Doctrine_Template_fzblameable();
        $this->actAs($timestampable0);
        $this->actAs($fzblameable0);
    }
}