<?php

/**
 * BaseEstadosPlanes
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idestadoplan
 * @property string $nombre
 * @property Doctrine_Collection $EstadosPlanes
 * 
 * @method integer             getIdestadoplan()  Returns the current record's "idestadoplan" value
 * @method string              getNombre()        Returns the current record's "nombre" value
 * @method Doctrine_Collection getEstadosPlanes() Returns the current record's "EstadosPlanes" collection
 * @method EstadosPlanes       setIdestadoplan()  Sets the current record's "idestadoplan" value
 * @method EstadosPlanes       setNombre()        Sets the current record's "nombre" value
 * @method EstadosPlanes       setEstadosPlanes() Sets the current record's "EstadosPlanes" collection
 * 
 * @package    sig
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEstadosPlanes extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('estados_planes');
        $this->hasColumn('idestadoplan', 'integer', null, array(
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
        $this->hasMany('PlanesEstudios as EstadosPlanes', array(
             'local' => 'idestadoplan',
             'foreign' => 'idestadoplan'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $fzblameable0 = new Doctrine_Template_fzblameable();
        $this->actAs($timestampable0);
        $this->actAs($fzblameable0);
    }
}