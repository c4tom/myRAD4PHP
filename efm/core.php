<?php
    /**
     * MyRad4PHP
     * Aplicacion desarrollada por Jorge Luis Prado Anci, en cuanto al licenciamiento 
     * pues esta aplicacion se entrega tal cual y tienen permiso de modifcarla y 
     * distribuirla de la manera que deseen, solo se les solicita que respeten el 
     * nombre del desarrolador indicando quien lo ha desarrollado y manteniendo 
     * los comentarios en los archivos del script, 
     * como esta aplicacion se entrega tal cual el creador no se hace responsable 
     * del uso o mal uso de la misma, en lo referido al soporte el creador intentara 
     * dar el soporte necesario pero dejando en claro que es meramente voluntario.
     * 
     * @package MyRad4PHP    
     * @author Jorge Luis Prado Ancí
     * @copyright http://myrad4php.wordpress.com
     * @version 0.59
     * @access public
     */
    class baseentity
    {
        public $nombre;
        public $displayname;
        public $mostrar;
        public $aCampos = array();
        public $campomostrar;
        public $readonly;
        public $grupo;
    } 
    
    class basecolumn
    {
        public $mostrar;
        public $readonly;
        public $espk;
        public $esfk;
        public $tipo;
        public $ancho;
        public $displayname;
        public $tipocontrol;
        public $requerido;
        public $nombre;
        public $posicion;
        public $filtrar;
        public $filtroobject;
        public $subtipo;
        public $campoRelacion;
        public $tablaRelacion;
        public $totalizar;
        public $defaultvalue;
        public $esunico;
        public $gotop;
        public $linkfields;
        function __construct()
        {
            $mostrar=true;
            $readonly=false;
            $espk=false;
            $esfk=false;
            $tipo="";
            $anch=0;
            $displayname="";
            $tipocontrol="";
            $requerido=true;
            $nombre="";
            $posicion=0;
            $filtrar=false;
            $filtroobject="";
            $subtipo="";
            $campoRelacion="";
            $tablaRelacion="";
            $totalizar=false;
            $defaultvalue=null;
            $esunico=false;
            $gotop=true;
            $linkfields="";            
        }
    }   
    class entidad
    {
        public $nombre;
        public $nomtabla;
        public $registros;
        public $regact;
        public $posact;
        public $cantver;
        public $tabla;
        public $metatabla;
        public $numcols;
        public $colsnames;
        public $coneccion;
        public $numregs;
        private $ordenar;
        public $aOrders;
        

        function __construct($_tabla) 
        {               
            $this->coneccion = $GLOBALS["coneccion"];
            eval("\$this->tabla = new ".$_tabla."();");
            eval("\$this->metatabla = new ".$_tabla."_meta();");
            
            $this->numcols = sizeof($this->metatabla->aCampos);
            $this->nombre = $_tabla;
            $this->nomtabla = $_tabla;
            $this->numcols=0;
            
            $acamposmetaordenados=array();        
            
            foreach($this->metatabla->aCampos as $campometa)
                $acamposmetaordenados[$campometa->posicion]=$campometa;
                
            foreach($acamposmetaordenados as $metacampo)
            {
                if($metacampo->mostrar==1)
                {
                    $this->colsnames[$metacampo->posicion]=$metacampo->displayname;
                    $this->numcols++;
                }
            }
            $this->posact=0;
            $this->cantver=-1;
            $this->numregs=0;
            $this->ordenar="";
            $this->aOrders=array();
        }

        public function actual()
        {
            return $this->registros[$this->regact];
        }

        public function primero()
        {
            $this->regact=0;
            return $this->registros[$this->regact];
        }

        public function ultimo()
        {
            $this->regact=sizeof($this->registros);
            return $this->registros[$this->regact];
        }

        public function siguiente()
        {
            if($this->regact!=sizeof($this->registros))
                $this->regact++;
            return $this->registros[$this->regact];
        }

        public function anterior()
        {
            if($this->regact!=0)
                $this->regact--;
            return $this->registros[$this->regact];
        }
        public function completefks()
        {
            foreach($this->registros as $registrosact)
            {
                $arr = $registrosact->toarray();
                foreach($arr as $key=>$value)                   
                    if($this->metatabla->aCampos[$key]->esfk)
                    {
                        $valfk= $this->fillfk($this->metatabla->aCampos[$key]->tablarelacion,$this->metatabla->aCampos[$key]->camporelacion,$value);
                        eval("\$registrosact->_".$this->metatabla->aCampos[$key]->tablarelacion."=\$valfk;");
                        
                    }
                
            }
        }
        public function completefk($aVals,$objtocomplet)
        {
            $arr = $aVals;
            foreach($arr as $key=>$value)                   
                if($this->metatabla->aCampos[$key]->esfk)
                {
                    $valfk= $this->fillfk($this->metatabla->aCampos[$key]->tablarelacion,$this->metatabla->aCampos[$key]->camporelacion,$value);
                     
                    eval("\$objtocomplet->_".$this->metatabla->aCampos[$key]->tablarelacion."=\$valfk;");                    
                }
            return $objtocomplet;
        }
        
        
        private function fillfk($tablafk,$campofk,$valorfk)
        {
            if($valorfk==null)
            {
                eval("\$ret = new ".$tablafk."();");
                return $ret;
            }            
            $objfk1 = new entidad($tablafk);
            
            $objfk1->getbyid($valorfk);            
            return $objfk1->registros[0];
            
        }

        public function fill()
        {
            
            $this->makeorders();
            if($this->cantver==-1)
                $valor = "SELECT * FROM ".$this->nomtabla.$this->ordenar;
            else
                $valor = "SELECT * FROM ".$this->nomtabla.$this->ordenar." limit ".$this->posact.",".$this->cantver;
            
            $this->fillvalores($valor);
            
        }

        public function fillvalores($valor)
        {           
            
            $registros=$this->coneccion->consulta($valor);            
            $aDatos=array();
            $n =0;
            
            while($row = mysql_fetch_array($registros))
            {
                eval("\$objTbl = new ".$this->nomtabla."();");
                
                foreach($this->metatabla->aCampos as $metacampo)
                {
                    
                    if($metacampo->esfk)
                    {

                        $row[$metacampo->camporeldes]=$this->fillfk($metacampo->tablarelacion,$metacampo->camporelacion,$row[$metacampo->nombre]);   
                    }
                }
                
                $objTbl->manual($row);
                
                $aDatos[$n]=$objTbl;
                $n++;
            }
            
            $this->registros=$aDatos;
            $this->regact=0;
            $this->numregs=$n;
        }
        public function makeorders()
        {
            
            if(sizeof($this->aOrders)>0)
            {
                $this->ordenar=" order by ";
                foreach($this->aOrders  as $parametro)            
                    $this->ordenar =$this->ordenar.$parametro.", ";
                $this->ordenar =substr($this->ordenar ,0,strlen($this->ordenar )-2);
            }  
            else
                $this->ordenar="";
        }
        public function repetido($objentidad)
        {
            $retornar= false;
            foreach($this->registros as $registro)
            {
                if(compareobjects($registro,$objentidad))
                    $retornar=true;
            }
            return $retornar;
        }
        
        public function campo_unico($objentidad,$campo)
        {
            $retornar= true;
            foreach($this->registros as $registro)
            {
                eval("\$valreg=\$registro->".$campo.";");
                eval("\$valnuevo=\$objentidad->".$campo.";");
                if($valreg==$valnuevo)
                    $retornar=false;
            }
            return $retornar;
        }
        
        public function filter($aparameters)
        {
            $this->makeorders();
               
            $cadpar = " where ";
            foreach($aparameters as $parametro)            
                $cadpar =$cadpar.$parametro["campo"].$parametro["valor"]." and ";
            $cadpar=substr($cadpar,0,strlen($cadpar)-5);            
            $valor = "SELECT * FROM ".$this->nomtabla.$cadpar.$this->ordenar;

            if($this->cantver>0)
                $valor = $valor." limit ".$this->posact.",".$this->cantver;
 
            $this->fillvalores($valor);
            
        }
        public function savechanges()
        {
            foreach($this->registros as $registro)
            {
                if($registro->esnuevo)
                {

                    $this->insertar($registro);
                    
                }
                if($registro->editado)
                    $this->update($registro);
            }
        }
        public function insertar($objentidad)
        {
            $cad="insert into ".$this->nomtabla."(";
            $cad1="";
            foreach($this->metatabla->aCampos as $campo)
            {
                if($campo->readonly!=1)
                {
                    if($campo->esunico)
                    {
                        if(!$this->campo_unico($objentidad,$campo->nombre))
                            return "El valor del campo: ".$campo->displayname." no puede repetirse en la tabla";
                    }
                    $cad=$cad.$campo->nombre.",";
                    
                    eval("\$valor = \$objentidad->".$campo->nombre.";");
                    if($campo->esfk)
                    {
                        if($campo->requerido==false)
                        {
                            if($valor==-1)
                                $cad1=$cad1."null,";
                            else
                                $cad1=$cad1."'".$valor."',";
                        }
                        else
                            $cad1=$cad1."'".$valor."',";
                    }
                    else
                        $cad1=$cad1."'".$valor."',";
                }                
            }
            $cad=substr($cad,0,strlen($cad)-1).") values (".substr($cad1,0,strlen($cad1)-1).")";

            $ret = $this->coneccion->consulta($cad);
            $this->regact=mysql_insert_id();
            if(strcmp($ret,"error")==0)  
                return "No se ha podido insertar el registro" ;  
            else
                "";        
        }        
        public function update($objentidad)
        {
            $cad="update ".$this->nomtabla." set ";
            $cad1=" where ";
            foreach($this->metatabla->aCampos as $campo)
            {
                if($campo->readonly!=1)
                {
                    if($campo->esunico)
                    {
                        if(!$this->campo_unico($objentidad,$campo->nombre))
                            return "El valor del campo: ".$campo->displayname." no puede repetirse en la tabla";
                    }
                    $cad=$cad.$campo->nombre." = ";
                    eval("\$valor = \$objentidad->".$campo->nombre.";");
                    if($campo->esfk)
                        {
                            if($campo->requerido==false)
                            {
                                if($valor==-1)
                                    $cad=$cad."null ,";
                                else
                                    $cad=$cad."'".$valor."',";                                
                            }
                            else
                                $cad=$cad."'".$valor."',";
                        }
                        else
                            $cad=$cad."'".$valor."',";  
                }                
                if($campo->espk)
                {
                    eval("\$valor = \$objentidad->".$campo->nombre.";");
                    $cad1=$cad1.$campo->nombre." = '".$valor."' ";
                }
            }
            $cad=substr($cad,0,strlen($cad)-1).$cad1;
            $ret=$this->coneccion->consulta($cad);
            if(strcmp($ret,"error")==0)  
                return "No se ha podido modificar el registro" ;  
            else
                "";    
        }
        public function delete($objentidad)
        {
            $cad="delete from ".$this->nomtabla." where ";
            $cad1="";
                foreach($this->metatabla->aCampos as $campo)
                {
                    if($campo->espk)
                    {
                        eval("\$valor = \$objentidad->".$campo->nombre.";");
                        $cad1=$cad1.$campo->nombre." = '".$valor."' ";
                    }
                }
                $cad=$cad.$cad1;
                $res = $this->coneccion->consulta($cad);
                if(strcmp($res,"error")==0)  
                    return "No se ha podido eliminar el registro" ;  
                else
                    "";    
            $this->primero();
        }
        public function getvaluesfk()
        {
            $avalores = array();
            $this->fill();
            $cPk="";
            foreach($this->metatabla->aCampos as $campo)
            {
                if($campo->espk)
                {
                    $cPk=$campo->nombre;
                }
            }
            if($cPk!="")
                foreach($this->registros as $regs)
                {
                    eval("\$cId = \$regs->".$cPk.";");
                    $avalores[]=array("clave"=>$cId,"valor"=>$regs->tostring());
                }
            return $avalores;
        }
        public function getbyid($id)
        {
            $pk="";
            foreach($this->metatabla->aCampos as $campo)
                if($campo->espk)
                    $pk=$campo->nombre;
            eval("\$f=new ".$this->nomtabla."();");
            $cad= "select * from ".$this->nomtabla." where ".$pk." = ".$id;
            $this->fillvalores($cad);
            return $this->registros[0];
        }
        public function toarray()
        {
            $adatos=array();
            foreach($this->registros as $registro)
            {
                foreach($this->metatabla->aCampos as $metadata)
                {
                    if($metadata->mostrar==1)
                        if($metadata->esfk==1)                           
                        {
                            eval("\$c=\$registro->_".$metadata->tablarelacion."->tostring();");
                            $adatos[]="<a href='index.php?tabla=".$metadata->tablarelacion."'>".$c."</a>";
                        }
                        else
                            eval("\$adatos[]=\$registro->".$metadata->nombre.";");
                        
                }
            }
            return $adatos;
        }
    }
    class registro
    {
        public $cantidad;
           
    }
?>
