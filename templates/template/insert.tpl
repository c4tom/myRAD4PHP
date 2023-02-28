{include file='header.tpl'}
            <div class="main">
                <h1 align="center">{$inserttitlelabel} {$titulo}</h1>
                <a href="{$rutabase}index.php">{$homelabel}</a>
                <div class="ui-widget">
                    <form method="post" action="insert.php?tabla={$tabla}&action=1" name="editar" enctype="multipart/form-data">
                        <div class="DDValidator">
                            {foreach $error as $err}
                            {$err}<br />
                            {/foreach}
                        </div>
                        <div id="{$tabla}">
                        <table class="mytable">
                            {foreach $acampos as $value}
                            <tr>
                                <td>
                                    {$value.etiqueta}
                                </td>
                                <td>
                                    {include file=$value.tipocontrol}
                                </td>
                            </tr>             
                            {/foreach}                                                   
                            <tr>
                                <td><input type="submit" value="{$acceptlabel}" name ="aceptar" class="submitButton"/></td>
                                <td><input type="submit" value="{$cancellabel}" name="cancelar"/></td>
                            </tr>
                        </table>
                        </div>
                    </form>
                </div>
            </div>
            <div class="clear">
            </div>

        </div>
    </body>
</html>
