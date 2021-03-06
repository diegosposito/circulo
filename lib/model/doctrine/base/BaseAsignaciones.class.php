<?php

/**
 * BaseAsignaciones
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idasignacion
 * @property integer $idaula
 * @property string $dia
 * @property date $inicio
 * @property date $fin
 * @property time $horainicio
 * @property time $horafin
 * @property string $observaciones
 * @property Aulas $Aulas
 * 
 * @method integer      getIdasignacion()  Returns the current record's "idasignacion" value
 * @method integer      getIdaula()        Returns the current record's "idaula" value
 * @method string       getDia()           Returns the current record's "dia" value
 * @method date         getInicio()        Returns the current record's "inicio" value
 * @method date         getFin()           Returns the current record's "fin" value
 * @method time         getHorainicio()    Returns the current record's "horainicio" value
 * @method time         getHorafin()       Returns the current record's "horafin" value
 * @method string       getObservaciones() Returns the current record's "observaciones" value
 * @method Aulas        getAulas()         Returns the current record's "Aulas" value
 * @method Asignaciones setIdasignacion()  Sets the current record's "idasignacion" value
 * @method Asignaciones setIdaula()        Sets the current record's "idaula" value
 * @method Asignaciones setDia()           Sets the current record's "dia" value
 * @method Asignaciones setInicio()        Sets the current record's "inicio" value
 * @method Asignaciones setFin()           Sets the current record's "fin" value
 * @method Asignaciones setHorainicio()    Sets the current record's "horainicio" value
 * @method Asignaciones setHorafin()       Sets the current record's "horafin" value
 * @method Asignaciones setObservaciones() Sets the current record's "observaciones" value
 * @method Asignaciones setAulas()         Sets the current record's "Aulas" value
 * 
 * @package    sig
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseAsignaciones extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('asignaciones');
        $this->hasColumn('idasignacion', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('idaula', 'integer', null, array(
             'type' => 'integer',
             'primary' => false,
             'notnull' => true,
             'default' => '0',
             ));
        $this->hasColumn('dia', 'string', 1, array(
             'type' => 'string',
             'length' => 1,
             ));
        $this->hasColumn('inicio', 'date', null, array(
             'type' => 'date',
             'notnull' => true,
             ));
        $this->hasColumn('fin', 'date', null, array(
             'type' => 'date',
             'notnull' => true,
             ));
        $this->hasColumn('horainicio', 'time', null, array(
             'type' => 'time',
             ));
        $this->hasColumn('horafin', 'time', null, array(
             'type' => 'time',
             ));
        $this->hasColumn('observaciones', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Aulas', array(
             'local' => 'idaula',
             'foreign' => 'idaula'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $fzblameable0 = new Doctrine_Template_fzblameable();
        $this->actAs($timestampable0);
        $this->actAs($fzblameable0);
    }
}