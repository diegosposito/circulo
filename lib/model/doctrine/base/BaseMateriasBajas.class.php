<?php

/**
 * BaseMateriasBajas
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $idbaja
 * @property integer $idmateriaplan
 * @property BajasAlumnos $BajasAlumnos
 * @property MateriasPlanes $MateriasPlanes
 * 
 * @method integer        getId()             Returns the current record's "id" value
 * @method integer        getIdbaja()         Returns the current record's "idbaja" value
 * @method integer        getIdmateriaplan()  Returns the current record's "idmateriaplan" value
 * @method BajasAlumnos   getBajasAlumnos()   Returns the current record's "BajasAlumnos" value
 * @method MateriasPlanes getMateriasPlanes() Returns the current record's "MateriasPlanes" value
 * @method MateriasBajas  setId()             Sets the current record's "id" value
 * @method MateriasBajas  setIdbaja()         Sets the current record's "idbaja" value
 * @method MateriasBajas  setIdmateriaplan()  Sets the current record's "idmateriaplan" value
 * @method MateriasBajas  setBajasAlumnos()   Sets the current record's "BajasAlumnos" value
 * @method MateriasBajas  setMateriasPlanes() Sets the current record's "MateriasPlanes" value
 * 
 * @package    sig
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseMateriasBajas extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('materias_bajas');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('idbaja', 'integer', null, array(
             'type' => 'integer',
             'primary' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('idmateriaplan', 'integer', null, array(
             'type' => 'integer',
             'primary' => false,
             'autoincrement' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('BajasAlumnos', array(
             'local' => 'idbaja',
             'foreign' => 'idbaja'));

        $this->hasOne('MateriasPlanes', array(
             'local' => 'idmateriaplan',
             'foreign' => 'idmateriaplan'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $fzblameable0 = new Doctrine_Template_fzblameable();
        $this->actAs($timestampable0);
        $this->actAs($fzblameable0);
    }
}