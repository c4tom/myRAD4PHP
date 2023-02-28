{include file="header.tpl"}
    <h1 >{$tittlebuilderlabel}</h1>
    <form name="frmbuilder" method="post" enctype="multipart/form-data">
        <table border="1">
            <tr>
                <td>{$titletablalabel}</td>
                <td>{$tittleopcioneslabel}</td>
            </tr>
            
                {foreach $tablas as $tabla}
                <tr>
                <td>
                    <label><input type="checkbox" name="tablas[]" value="{$tabla[0]}" checked="true"/>{$tabla[0]}</label>
                </td>
                <td>
                    {html_checkboxes name=$tabla[1] values=$opciones.ids output=$opciones.nombres separator=' ' label_ids=true selected=$valores}
                </td>
                </tr>
                {/foreach}
        </table>
        <br />
        <label><input type="checkbox" name="separedfiles" checked="true"/> Archivos separados</label>
        <br />
        
        
        <label><input type="checkbox" name="conservar" /> Si ya existe, conservar contenido como comentario</label>
        <br />
        Carpeta de destino: {$destinodal}
        <br />
        <input type="submit" name="procesar" value="Procesar" />
    </form>
</html>