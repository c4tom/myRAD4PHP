<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
        <link href="{$rutabase}css/default.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="{$rutabase}scripts/jquery-1.4.1.js"></script>
        <script type="text/javascript" src="{$rutabase}swdd/scripts/genericos.js"></script>
        <script type="text/javascript" src="{$rutabase}swdd/scripts/{$tabla}.js"></script>
        <link rel="stylesheet" type="text/css" href="{$rutabase}css/ddlevelsfiles/ddlevelsmenu-base.css" />
        <link rel="stylesheet" type="text/css" href="{$rutabase}css/ddlevelsfiles/ddlevelsmenu-topbar.css" />
        <link rel="stylesheet" type="text/css" href="{$rutabase}css/ddlevelsfiles/ddlevelsmenu-sidebar.css" />
        <script type="text/javascript" src="{$rutabase}scripts/ddlevelsmenu.js">

        /***********************************************
        * All Levels Navigational Menu- (c) Dynamic Drive DHTML code library (http://www.dynamicdrive.com)
        * This notice MUST stay intact for legal use
        * Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
        ***********************************************/
        
        </script>
    </head>
    <body>
    <h1 >{$configtittlelabel}</h1>
    <div class="DDValidator">
    {foreach $error as $err}
    {$err}<br />
    {/foreach}
    </div>    
    <form name="frmbuilder" method="post" enctype="multipart/form-data">

        <table border="1">
            <tr>
                <td>{$serverlabel}</td>
                <td><input type="text" name="txtserver"/></td>
            </tr>
            <tr>
                <td>{$databaselabel}</td>
                <td><input type="text" name="txtbdname"/></td>
            </tr>
            <tr>
                <td>{$userdblabel}</td>
                <td><input type="text" name="txtuser"/></td>
            </tr>
            <tr>
                <td>{$clavelabel}</td>
                <td><input type="text" name="txtclave"/></td>
            </tr>
            <tr>
                <td>{$nomapplabel}</td>
                <td><input type="text" name="txtappname"/></td>
            </tr>
            <tr>
                <td>{$rutaserverlabel}</td>
                <td><input type="text" name="txtruta"/></td>
            </tr>
            <tr>
                <td>{$rutaormlabel}</td>
                <td><input type="text" name="txtdestino" value="/dal"/></td>
            </tr>
            <tr>
                <td>{$idiomauserlabel}</td>
                <td>
                    <select name="cboidioma"  >
                        {html_options values=$indices output=$indices}
                    </select>

                </td>
            </tr>
            <tr>
                <td><input type="submit" name="procesar" value="Procesar" /></td>
                <td><input type="submit" name="saltar" value="Ir al generador de clases" /></td>
            </tr>
        </table>
        <br />
        
    </form>
    </body>
</html>