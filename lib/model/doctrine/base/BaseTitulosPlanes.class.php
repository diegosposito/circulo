<?php

/**
 * BaseTitulosPlanes
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idtituloplan
 * @property integer $idtitulo
 * @property integer $idplanestudio
 * @property boolean $tieneorientacion
 * @property boolean $eligeorientacion
 * @property integer $totalcreditoegreso
 * @property integer $idmodoegreso
 * @property string $sumacredito
 * @property Titulos $Titulos
 * @property PlanesEstudios $PlanesEstudios
 * @property ModosEgreso $ModosEgreso
 * 
 * @method integer        getIdtituloplan()       Returns the current record's "idtituloplan" value
 * @method integer        getIdtitulo()           Returns the current record's "idtitulo" value
 * @method integer        getIdplanestudio()      Returns the current record's "idplanestudio" value
 * @method boolean        getTieneorientacion()   Returns the current record's "tieneorientacion" value
 * @method boolean        getEligeorientacion()   Returns the current record's "eligeorientacion" value
 * @method integer        getTotalcreditoegreso() Returns the current record's "totalcreditoegreso" value
 * @method integer        getIdmodoegreso()       Returns the current record's "idmodoegreso" value
 * @method string         getSumacredito()        Returns the current record's "sumacredito" value
 * @method Titulos        getTitulos()            Returns the current record's "Titulos" value
 * @method PlanesEstudios getPlanesEstudios()     Returns the current record's "PlanesEstudios" value
 * @method ModosEgreso    getModosEgreso()        Returns the current record's "ModosEgreso" value
 * @method TitulosPlanes  setIdtituloplan()       Sets the current record's "idtituloplan" value
 * @method TitulosPlanes  setIdtitulo()           Sets the current record's "idtitulo" value
 * @method TitulosPlanes  setIdplanestudio()      Sets the current record's "idplanestudio" value
 * @method TitulosPlanes  setTieneorientacion()   Sets the current record's "tieneorientacion" value
 * @method TitulosPlanes  setEligeorientacion()   Sets the current record's "eligeorientacion" value
 * @method TitulosPlanes  setTotalcreditoegreso() Sets the current record's "totalcreditoegreso" value
 * @method TitulosPlanes  setIdmodoegreso()       Sets the current record's "idmodoegreso" value
 * @method TitulosPlanes  setSumacredito()        Sets the current record's "sumacredito" value
 * @method TitulosPlanes  setTitulos()            Sets the current record's "Titulos" value
 * @method TitulosPlanes  setPlanesEstudios()     Sets the current record's "PlanesEstudios" value
 * @method TitulosPlanes  setModosEgreso()        Sets the current record's "ModosEgreso" value
 * 
 * @package    sig
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTitulosPlanes extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('titulos_planes');
        $this->hasColumn('idtituloplan', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('idtitulo', 'integer', null, array(
             'type' => 'integer',
             'primary' => false,
             'default' => '0',
             ));
        $this->hasColumn('idplanestudio', 'integer', null, array(
             'type' => 'integer',
             'primary' => false,
             'default' => '0',
             ));
        $this->hasColumn('tieneorientacion', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => 1,
             ));
        $this->hasColumn('eligeorientacion', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => 1,
             ));
        $this->hasColumn('totalcreditoegreso', 'integer', null, array(
             'type' => 'integer',
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             ));
        $this->hasColumn('idmodoegreso', 'integer', null, array(
             'type' => 'integer',
             'primary' => false,
             'default' => '0',
             ));
        $this->hasColumn('sumacredito', 'string', 2, array(
             'type' => 'string',
             'notnull' => true,
             'default' => '',
             'length' => 2,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Titulos', array(
             'local' => 'idtitulo',
             'foreign' => 'idtitulo'));

        $this->hasOne('PlanesEstudios', array(
             'local' => 'idplanestudio',
             'foreign' => 'idplanestudio'));

        $this->hasOne('ModosEgreso', array(
             'local' => 'idmodoegreso',
             'foreign' => 'idmodoegreso'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $fzblameable0 = new Doctrine_Template_fzblameable();
        $this->actAs($timestampable0);
        $this->actAs($fzblameable0);
    }
}