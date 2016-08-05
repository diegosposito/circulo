<?php

/**
 * BaseEncuestasAlumnos
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $idencuesta
 * @property integer $idalumno
 * @property date $fecha
 * @property Encuestas $Encuestas
 * @property Alumnos $Alumnos
 * 
 * @method integer          getId()         Returns the current record's "id" value
 * @method integer          getIdencuesta() Returns the current record's "idencuesta" value
 * @method integer          getIdalumno()   Returns the current record's "idalumno" value
 * @method date             getFecha()      Returns the current record's "fecha" value
 * @method Encuestas        getEncuestas()  Returns the current record's "Encuestas" value
 * @method Alumnos          getAlumnos()    Returns the current record's "Alumnos" value
 * @method EncuestasAlumnos setId()         Sets the current record's "id" value
 * @method EncuestasAlumnos setIdencuesta() Sets the current record's "idencuesta" value
 * @method EncuestasAlumnos setIdalumno()   Sets the current record's "idalumno" value
 * @method EncuestasAlumnos setFecha()      Sets the current record's "fecha" value
 * @method EncuestasAlumnos setEncuestas()  Sets the current record's "Encuestas" value
 * @method EncuestasAlumnos setAlumnos()    Sets the current record's "Alumnos" value
 * 
 * @package    sig
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEncuestasAlumnos extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('encuestas_alumnos');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('idencuesta', 'integer', null, array(
             'type' => 'integer',
             'primary' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('idalumno', 'integer', null, array(
             'type' => 'integer',
             'primary' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('fecha', 'date', null, array(
             'type' => 'date',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Encuestas', array(
             'local' => 'idencuesta',
             'foreign' => 'idencuesta'));

        $this->hasOne('Alumnos', array(
             'local' => 'idalumno',
             'foreign' => 'idalumno'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $fzblameable0 = new Doctrine_Template_fzblameable();
        $this->actAs($timestampable0);
        $this->actAs($fzblameable0);
    }
}