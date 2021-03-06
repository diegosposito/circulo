<?php

/**
 * BaseCatedras
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idcatedra
 * @property integer $idmateriaplan
 * @property integer $idsede
 * @property boolean $activa
 * @property MateriasPlanes $MateriasPlanes
 * @property Sedes $Sedes
 * @property Doctrine_Collection $Catedras
 * 
 * @method integer             getIdcatedra()      Returns the current record's "idcatedra" value
 * @method integer             getIdmateriaplan()  Returns the current record's "idmateriaplan" value
 * @method integer             getIdsede()         Returns the current record's "idsede" value
 * @method boolean             getActiva()         Returns the current record's "activa" value
 * @method MateriasPlanes      getMateriasPlanes() Returns the current record's "MateriasPlanes" value
 * @method Sedes               getSedes()          Returns the current record's "Sedes" value
 * @method Doctrine_Collection getCatedras()       Returns the current record's "Catedras" collection
 * @method Catedras            setIdcatedra()      Sets the current record's "idcatedra" value
 * @method Catedras            setIdmateriaplan()  Sets the current record's "idmateriaplan" value
 * @method Catedras            setIdsede()         Sets the current record's "idsede" value
 * @method Catedras            setActiva()         Sets the current record's "activa" value
 * @method Catedras            setMateriasPlanes() Sets the current record's "MateriasPlanes" value
 * @method Catedras            setSedes()          Sets the current record's "Sedes" value
 * @method Catedras            setCatedras()       Sets the current record's "Catedras" collection
 * 
 * @package    sig
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCatedras extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('catedras');
        $this->hasColumn('idcatedra', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('idmateriaplan', 'integer', null, array(
             'type' => 'integer',
             'primary' => false,
             'default' => '0',
             ));
        $this->hasColumn('idsede', 'integer', null, array(
             'type' => 'integer',
             'primary' => false,
             'default' => '0',
             ));
        $this->hasColumn('activa', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => 1,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('MateriasPlanes', array(
             'local' => 'idmateriaplan',
             'foreign' => 'idmateriaplan'));

        $this->hasOne('Sedes', array(
             'local' => 'idsede',
             'foreign' => 'idsede'));

        $this->hasMany('AluMat as Catedras', array(
             'local' => 'idcatedra',
             'foreign' => 'idcatedra'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $fzblameable0 = new Doctrine_Template_fzblameable();
        $this->actAs($timestampable0);
        $this->actAs($fzblameable0);
    }
}