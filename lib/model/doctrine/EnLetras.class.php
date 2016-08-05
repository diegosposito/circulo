<?php

/**
 * EnLetras
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ucu
 * @subpackage model
 * @author     Ing. Marcelo Udrizard
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class EnLetras
{
 var $Void = "";
  var $SP = " ";
  var $Dot = ".";
  var $Zero = "0";
  var $Neg = "Menos";
  
function ValorEnLetras($x) 
{
    $s="";
    $Ent="";
    $Frc="";
    
    if(intval(number_format($x,2,'.','') )!=$x) //<- averiguar si tiene decimales
      $s = number_format($x,2,'.','');
    else
      $s = number_format($x,0,'.','');
       
    $Pto = strpos($s, $this->Dot);
        
    if ($Pto === false)
    {
      $Ent = $s;
      $Frc = $this->Void;
    }
    else
    {
      $Ent = substr($s, 0, $Pto );
      $Frc =  substr($s, $Pto+1);
    }

    if($Ent == $this->Zero || $Ent == $this->Void)
       $s = "Cero ";
    elseif( strlen($Ent) > 7)
    {
       $s = $this->SubValLetra(intval( substr($Ent, 0,  strlen($Ent) - 6))) . 
             "Millones " . $this->SubValLetra(intval(substr($Ent,-6, 6)));
    }
    else
    {
      $s = $this->SubValLetra(intval($Ent));
    }

    if (substr($s,-9, 9) == "Millones " || substr($s,-7, 7) == "Millón ")
       $s = $s . "de ";

    return ($s);
   
}


function SubValLetra($numero) 
{
    $Ptr="";
    $n=0;
    $i=0;
    $x ="";
    $Rtn ="";
    $Tem ="";

    $x = trim("$numero");
    $n = strlen($x);

    $Tem = $this->Void;
    $i = $n;
    
    while( $i > 0)
    {
       $Tem = $this->Parte(intval(substr($x, $n - $i, 1). 
                           str_repeat($this->Zero, $i - 1 )));
       If( $Tem != "Cero" )
          $Rtn .= $Tem . $this->SP;
       $i = $i - 1;
    }

    


    //--------------------- FiltroEspeciales ------------------------------
    $Rtn=str_replace("diez cero", "diez", $Rtn );
    $Rtn=str_replace("diez un", "once", $Rtn );
    $Rtn=str_replace("diez dos", "doce", $Rtn );
    $Rtn=str_replace("diez tres", "trece", $Rtn );
    $Rtn=str_replace("diez cuatro", "catorce", $Rtn );
    $Rtn=str_replace("diez cinco", "quince", $Rtn );
    $Rtn=str_replace("diez seis", "dieciseis", $Rtn );
    $Rtn=str_replace("diez siete", "diecisiete", $Rtn );
    $Rtn=str_replace("diez ocho", "dieciocho", $Rtn );
    $Rtn=str_replace("diez nueve", "diecinueve", $Rtn );
    $Rtn=str_replace("veinte cero", "veinte", $Rtn );
    $Rtn=str_replace("veinte un", "veintiun", $Rtn );
    $Rtn=str_replace("veinte dos", "veintidos", $Rtn );
    $Rtn=str_replace("veinte tres", "veintitres", $Rtn );
    $Rtn=str_replace("veinte cuatro", "veinticuatro", $Rtn );
    $Rtn=str_replace("veinte cinco", "veinticinco", $Rtn );
    $Rtn=str_replace("veinte seis", "veintiseís", $Rtn );
    $Rtn=str_replace("veinte siete", "veintisiete", $Rtn );
    $Rtn=str_replace("veinte ocho", "veintiocho", $Rtn );
    $Rtn=str_replace("veinte nueve", "veintinueve", $Rtn );

    //--------------------- FiltroUn ------------------------------
    If(substr($Rtn,0,1) == "M") $Rtn = "Un " . $Rtn;
    //--------------------- Adicionar Y ------------------------------
    for($i=65; $i<=88; $i++)
    {
      If($i != 77)
         $Rtn=str_replace("a " . Chr($i), "* y " . Chr($i), $Rtn);
    }
    $Rtn=str_replace("*", "a" , $Rtn);
    return($Rtn);
}


function ReplaceStringFrom(&$x, $OldWrd, $NewWrd, $Ptr)
{
  $x = substr($x, 0, $Ptr)  . $NewWrd . substr($x, strlen($OldWrd) + $Ptr);
}


function Parte($x)
{
    $Rtn='';
    $t='';
    $i='';
    Do
    {
      switch($x)
      {
         Case 0:  $t = "cero";break;
         Case 1:  $t = "un";break;
         Case 2:  $t = "dos";break;
         Case 3:  $t = "tres";break;
         Case 4:  $t = "cuatro";break;
         Case 5:  $t = "cinco";break;
         Case 6:  $t = "seis";break;
         Case 7:  $t = "siete";break;
         Case 8:  $t = "ocho";break;
         Case 9:  $t = "nueve";break;
         Case 10: $t = "diez";break;
         Case 20: $t = "veinte";break;
         Case 30: $t = "treinta";break;
         Case 40: $t = "cuarenta";break;
         Case 50: $t = "cincuenta";break;
         Case 60: $t = "sesenta";break;
         Case 70: $t = "setenta";break;
         Case 80: $t = "ochenta";break;
         Case 90: $t = "noventa";break;
         Case 100: $t = "cien";break;
         Case 200: $t = "doscientos";break;
         Case 300: $t = "trescientos";break;
         Case 400: $t = "cuatrocientos";break;
         Case 500: $t = "quinientos";break;
         Case 600: $t = "seiscientos";break;
         Case 700: $t = "setecientos";break;
         Case 800: $t = "ochocientos";break;
         Case 900: $t = "novecientos";break;
         Case 1000: $t = "mil";break;
         Case 1000000: $t = "millón";break;
      }

      If($t == $this->Void)
      {
        $i = $i + 1;
        $x = $x / 1000;
        If($x== 0) $i = 0;
      }
      else
         break;
           
    }while($i != 0);
   
    $Rtn = $t;
    Switch($i)
    {
       Case 0: $t = $this->Void;break;
       Case 1: $t = " mil";break;
       Case 2: $t = " millones";break;
       Case 3: $t = " billones";break;
    }
    return($Rtn . $t);
}
}
