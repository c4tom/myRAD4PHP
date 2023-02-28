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
class loaderclass
{
    public $aParametros;
    public function ir($destino)
    {
        $cad="";
        foreach($this->aParametros as $parametro)
            $cad.=$parametro->nombre."=".$parametro->valor."&";
         header("Location: ".$destino."?".substr($cad,0,strlen($cad)-1));
    }
}
class parametro
{
    public $nombre;
    public $valor;
    function __construct($_nombre="",$_valor="")
    {
        $this->nombre=$_nombre;
        $tis->valor=$_valor;
    }
}
?>