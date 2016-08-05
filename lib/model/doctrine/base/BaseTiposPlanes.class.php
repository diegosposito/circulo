<?php

/**
 * BaseTiposPlanes
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idtipoplan
 * @property string $nombre
 * @property Doctrine_Collection $TiposPlanes
 * 
 * @method integer             getIdtipoplan()  Returns the current record's "idtipoplan" value
 * @method string              getNombre()      Returns the current record's "nombre" value
 * @method Doctrine_Collection getTiposPlanes() Returns the current record's "TiposPlanes" collection
 * @method TiposPlanes         setIdtipoplan()  Sets the current record's "idtipoplan" value
 * @method TiposPlanes         setNombre()      Sets the current record's "nombre" value
 * @method TiposPlanes         setTiposPlanes() Sets the current record's "TiposPlanes" collection
 * 
 * @package    sig
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTiposPlanes extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('tipos_planes');
        $this->hasColumn('idtipoplan', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('nombre', 'string', 255, array(
             'type' => 'string',
             'primary' => false,
             'notnull' => true,
             'default' => '',
             'length' => 255,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('PlanesEstudios as TiposPlanes', array(
             'local' => 'idtipoplan',
             'foreign' => 'idtipoplan'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $fzblameable0 = new Doctrine_Template_fzblameable();
        $this->actAs($timestampable0);
        $this->actAs($fzblameable0);
    }
}