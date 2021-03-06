<?php

/**
 * BaseCicloLectivo
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $ciclo
 * @property date $inicio
 * @property date $fin
 * @property Doctrine_Collection $InscripcionesCicloLectivo
 * 
 * @method string              getCiclo()                     Returns the current record's "ciclo" value
 * @method date                getInicio()                    Returns the current record's "inicio" value
 * @method date                getFin()                       Returns the current record's "fin" value
 * @method Doctrine_Collection getInscripcionesCicloLectivo() Returns the current record's "InscripcionesCicloLectivo" collection
 * @method CicloLectivo        setCiclo()                     Sets the current record's "ciclo" value
 * @method CicloLectivo        setInicio()                    Sets the current record's "inicio" value
 * @method CicloLectivo        setFin()                       Sets the current record's "fin" value
 * @method CicloLectivo        setInscripcionesCicloLectivo() Sets the current record's "InscripcionesCicloLectivo" collection
 * 
 * @package    sig
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCicloLectivo extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('ciclo_lectivo');
        $this->hasColumn('ciclo', 'string', 60, array(
             'type' => 'string',
             'length' => 60,
             ));
        $this->hasColumn('inicio', 'date', null, array(
             'type' => 'date',
             'notnull' => true,
             ));
        $this->hasColumn('fin', 'date', null, array(
             'type' => 'date',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('InscripcionesCicloLectivo', array(
             'local' => 'id',
             'foreign' => 'idciclolectivo'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $fzblameable0 = new Doctrine_Template_fzblameable();
        $this->actAs($timestampable0);
        $this->actAs($fzblameable0);
    }
}