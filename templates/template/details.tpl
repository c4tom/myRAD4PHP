{include file='header.tpl'}
            <div class="main">
                <h1 align="center">{$detailstitlelabel} {$titulo}</h1>
                <a href="{$rutabase}index.php">{$homelabel}</a>
                <div class="DD">
                    <form method="post" action="edit.php?tabla={$tabla}&idreg={$idregistro}" name="editar" enctype="multipart/form-data">
                        <table class="mytable">
                            {foreach $acampos as $campo}
                            {foreach $campo as $value}
                            <tr>
                                <td>
                                    {$value[0]}
                                </td>
                                <td>
                                    {$value[1]}
                                </td>
                            </tr>
                            {/foreach}               
                            {/foreach}                                                   
                            <tr>
                                
                                <td><a href="list.php?tabla={$tabla}" class="DDLightHeader">{$returnlistlabel}</a></td>
                            </tr>
                        </table>
                    </form>
                </div>
                
            </div>
            <div class="clear">
            </div>

        </div>
    </body>
</html>
