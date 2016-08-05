<?php

/**
 * BaseNoticias
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idsede
 * @property string $titulo
 * @property string $intro
 * @property string $descripcion
 * @property integer $idusuario
 * @property integer $orden
 * @property date $inicio
 * @property date $fin
 * @property boolean $leer_mas
 * @property boolean $is_active
 * @property boolean $privada
 * @property Sedes $Sedes
 * @property Doctrine_Collection $Noticias
 * 
 * @method integer             getIdsede()      Returns the current record's "idsede" value
 * @method string              getTitulo()      Returns the current record's "titulo" value
 * @method string              getIntro()       Returns the current record's "intro" value
 * @method string              getDescripcion() Returns the current record's "descripcion" value
 * @method integer             getIdusuario()   Returns the current record's "idusuario" value
 * @method integer             getOrden()       Returns the current record's "orden" value
 * @method date                getInicio()      Returns the current record's "inicio" value
 * @method date                getFin()         Returns the current record's "fin" value
 * @method boolean             getLeerMas()     Returns the current record's "leer_mas" value
 * @method boolean             getIsActive()    Returns the current record's "is_active" value
 * @method boolean             getPrivada()     Returns the current record's "privada" value
 * @method Sedes               getSedes()       Returns the current record's "Sedes" value
 * @method Doctrine_Collection getNoticias()    Returns the current record's "Noticias" collection
 * @method Noticias            setIdsede()      Sets the current record's "idsede" value
 * @method Noticias            setTitulo()      Sets the current record's "titulo" value
 * @method Noticias            setIntro()       Sets the current record's "intro" value
 * @method Noticias            setDescripcion() Sets the current record's "descripcion" value
 * @method Noticias            setIdusuario()   Sets the current record's "idusuario" value
 * @method Noticias            setOrden()       Sets the current record's "orden" value
 * @method Noticias            setInicio()      Sets the current record's "inicio" value
 * @method Noticias            setFin()         Sets the current record's "fin" value
 * @method Noticias            setLeerMas()     Sets the current record's "leer_mas" value
 * @method Noticias            setIsActive()    Sets the current record's "is_active" value
 * @method Noticias            setPrivada()     Sets the current record's "privada" value
 * @method Noticias            setSedes()       Sets the current record's "Sedes" value
 * @method Noticias            setNoticias()    Sets the current record's "Noticias" collection
 * 
 * @package    sig
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseNoticias extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('noticias');
        $this->hasColumn('idsede', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('titulo', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('intro', 'string', 500, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 500,
             ));
        $this->hasColumn('descripcion', 'string', 4000, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 4000,
             ));
        $this->hasColumn('idusuario', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('orden', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('inicio', 'date', null, array(
             'type' => 'date',
             'notnull' => true,
             ));
        $this->hasColumn('fin', 'date', null, array(
             'type' => 'date',
             'notnull' => true,
             ));
        $this->hasColumn('leer_mas', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => 0,
             ));
        $this->hasColumn('is_active', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => 0,
             ));
        $this->hasColumn('privada', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => 0,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Sedes', array(
             'local' => 'idsede',
             'foreign' => 'idsede'));

        $this->hasMany('NoticiasCarrera as Noticias', array(
             'local' => 'id',
             'foreign' => 'idnoticia'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $fzblameable0 = new Doctrine_Template_fzblameable();
        $this->actAs($timestampable0);
        $this->actAs($fzblameable0);
    }
}