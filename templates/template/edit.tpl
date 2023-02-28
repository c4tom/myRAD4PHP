{include file='header.tpl'}
            <div class="ui-widget">
                <h1 align="center">{$edittitlelabel} {$titulo}</h1>
                <div class="DD">
                    <form method="post" action="edit.php?tabla={$tabla}&idreg={$idregistro}" name="editar" enctype="multipart/form-data">
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
                                    
                                    <td><input type="submit" value="{$acceptlabel}" name ="aceptar" class="boton"/></td>
                                    <td><input type="submit" value="{$cancellabel}" name="cancelar" class="boton"/></td>
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
