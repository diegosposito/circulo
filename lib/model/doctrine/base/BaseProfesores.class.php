<?php

/**
 * BaseProfesores
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idprofesor
 * @property integer $idpersona
 * @property integer $idfacultad
 * @property string $legajo
 * @property Personas $Personas
 * @property Facultades $Facultades
 * @property Doctrine_Collection $Profesores
 * 
 * @method integer             getIdprofesor() Returns the current record's "idprofesor" value
 * @method integer             getIdpersona()  Returns the current record's "idpersona" value
 * @method integer             getIdfacultad() Returns the current record's "idfacultad" value
 * @method string              getLegajo()     Returns the current record's "legajo" value
 * @method Personas            getPersonas()   Returns the current record's "Personas" value
 * @method Facultades          getFacultades() Returns the current record's "Facultades" value
 * @method Doctrine_Collection getProfesores() Returns the current record's "Profesores" collection
 * @method Profesores          setIdprofesor() Sets the current record's "idprofesor" value
 * @method Profesores          setIdpersona()  Sets the current record's "idpersona" value
 * @method Profesores          setIdfacultad() Sets the current record's "idfacultad" value
 * @method Profesores          setLegajo()     Sets the current record's "legajo" value
 * @method Profesores          setPersonas()   Sets the current record's "Personas" value
 * @method Profesores          setFacultades() Sets the current record's "Facultades" value
 * @method Profesores          setProfesores() Sets the current record's "Profesores" collection
 * 
 * @package    sig
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseProfesores extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('profesores');
        $this->hasColumn('idprofesor', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('idpersona', 'integer', null, array(
             'type' => 'integer',
             'primary' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('idfacultad', 'integer', null, array(
             'type' => 'integer',
             'primary' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('legajo', 'string', 100, array(
             'type' => 'string',
             'primary' => false,
             'notnull' => true,
             'default' => ' ',
             'autoincrement' => false,
             'length' => 100,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Personas', array(
             'local' => 'idpersona',
             'foreign' => 'idpersona'));

        $this->hasOne('Facultades', array(
             'local' => 'idfacultad',
             'foreign' => 'idfacultad'));

        $this->hasMany('Designaciones as Profesores', array(
             'local' => 'idprofesor',
             'foreign' => 'idprofesor'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $fzblameable0 = new Doctrine_Template_fzblameable();
        $this->actAs($timestampable0);
        $this->actAs($fzblameable0);
    }
}