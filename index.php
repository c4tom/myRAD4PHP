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
     * @author Jorge Luis Prado Anc?
     * @copyright http://myrad4php.wordpress.com
     * @version 0.59
     * @access public
     */
    if(!file_exists("config/setings.php"))
        header("Location: efm/seleidioma.php");
    include('config/setings.php');
    include('config/setup.php');
    $smarty=new Smarty_myrad4php();
    setidioma($smarty);
    islogin($smarty);
    
    $dc = new datacontex();
    $smarty->assign("data",makegridini($dc->tablas));       
    $smarty->assign("titulo","Tablas");
    $smarty->display('index.tpl');
    
?>