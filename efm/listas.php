<?php
    class lista
    {
        protected $datos = array();
        public $contador=-1;
        //adiciona un elemento al array
        public function add($valor)
        {
            $this->datos[]=$valor;
            $this->contador++;
        }
        //elimina un elemento de la lista
        public function remove($index)
        {
            unset($this->datos[$index]);
            $tmp=array_values($this->datos);
            $this->datos = $tmp;
            $this->contador--;
        }
        //reemplaza un valor en el array por indice
        //retorna true si se udo cambiar
        public function reemplazaXindice($valor, $index)
        {
            
            if($index>$this->contador)
                return false;
            $this->datos[$index]=$valor;
            return true;
        }
        //reemplaza un valor en el array basado en un valor actual
        //va a retornar el indice reemplazado
        public function reemplazarXvalor($objactual,$valor)
        {
            $esta=$this->existe($objactual);
            if($esta>=0)
                $this->datos[$esta]=$valor;
            return $esta;
        }
        //retorna el indice de un objeto en la lista
        public function existe($valor)
        {
            $retornar = -1;
            for($k=0;$k<=$this->contador;$k++)
            {
                if($this->compareobjects($this->datos[$k],$valor))
                {
                    $retornar = $k;
                    break;
                }                   
            }
            return $retornar;
        }
        //retorna el objeto que se encuentra en la posicion 
        public function getItem($indice)
        {
            if($this->contador<$indice)
                return null;
            if(!isset($this->datos[$indice]))
                return null;
            return $this->datos[$indice];
        }
        //retorna el array de valores
        public function items()
        {
            return $this->datos;
        }
        //compara dos objetos 
        public function compareobjects($obj1,$obj2)
        {
            $resultado = false;
            //voy a verificar si sea implementado objetos
            if(!is_object($obj1))
            {
                if($obj1 == $obj2)
                    return true;
                else
                    return false;
            }
            if(!is_object($obj2))
            {
                if($obj1 == $obj2)
                    return true;
                else
                    return false;
            }
            
            //creo los objetos basados en ReflectionClass 
            $refObj1 = new ReflectionClass($obj1);
            $refObj2 = new ReflectionClass($obj2);
            //voy a comparar si ambos objetos tienen el mismo nombre de clase
            if($refObj1->getName()==$refObj2->getName() )
            {
                //obtengo las propiedades de cada uno de los objetos
               $aProp1=$refObj1->getProperties(); 
               $aProp2=$refObj2->getProperties();
               //voy a iterar entre todas las propiedades de los objetos
               //como ya determine que ambos son de la misma clase
               //ambos tienen la misma cantidad de propiedades
               for($k=0;$k<sizeof($aProp2);$k++)
               {
                //si la propiedad es privada la coloco como accesible
                if($aProp1[$k]->isPrivate())
                {
                    $aProp1[$k]->setAccessible(true);
                    $aProp2[$k]->setAccessible(true);
                }
                //si la propiedad es protegida la coloco como accesible
                if($aProp1[$k]->isProtected())
                {
                    $aProp1[$k]->setAccessible(true);
                    $aProp2[$k]->setAccessible(true);
                }
                //comparo ambos valores
                if($aProp1[$k]->getValue($obj1)==$aProp2[$k]->getValue($obj2))
                    $resultado = true;
                else
                {
                    //si una de las propiedades no es igual en ambos objetos
                    //termino el for
                    $resultado=false;
                    break 1;
                }
               }
            }
            else
                $resultado = false;
            
            return $resultado ;
        }     
        
    }
    
?>