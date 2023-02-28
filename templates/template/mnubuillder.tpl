{include file="header.tpl"}
<script src="{$rutabase}scripts/rutabase.js"></script>
        <script src="{$rutabase}scripts/jquery.nestable.js"></script>
    <h1 >{$tittlebuilderlabel}</h1>
    <form name="frmmnubuilder" method="post" enctype="multipart/form-data">
        <h1>Menu Buillder GUI</h1>
        <button type="button" id="helpen">Help</button>
        <button type="button" id="helpes">Ayuda</button>
        <button type="button" id="bntgettables">Get tables from model</button>
        <button type="button" id="bntgetmenu">Get current menu</button>
        <br />
        <div id="help-en">
            1. Fill textbox labeled "Menu label" with label for menu example: Google.<br />
            2. Fill textbox labeled "URL" with url for menu example: http://www.google.com<br />
            3. Click in "Add item"<br />
            4. For order your submenus drag and drop elements in left list, you can  see a shadow in cian color when your drag item.<br />
            5. For deleted one element of menu, drag and drop element from left list to right list.<br />
            <button type="button" id="close">Close</button>
        </div>
        <div id="help-es">
            1. Complete el campo etiquetado por "Menu label" por ejemplo con: Google.<br />
            2. Ingrese la direccion de destino en el campo etiquetado "URL" por ejemplo: http://www.google.com<br />
            3. Click en "Add item"<br />
            4. Para ordenar los elementos del menu y crear submenus arrastre y suelte los elemento sde la lista a la izquierda, 
            podra ver una sombra en color celeste mientras arrastra el elemento.<br />
            5. Para eliminar un elemento arrastre y suelte el elemento de la lista de la izquierda en lasta de la derecha.<br />
            <button type="button" id="cerrar">Cerrar</button>
        </div>
    	<label>Menu label</label><input type="text" id="txtnombre" /><br>
    	<label>URL</label><input type="text" id="txtDestino" value="#" /><br>
    	<button type="button" id="bntAdd">Add item</button>
        <br />              
        <div class="cf nestable-lists">
            <div class="dd" id="nestable">
                <ol class="dd-list" id="lista">
                    <li class="dd-item" data-id="1" data-mnulabel="Home" data-url="#">
                        <div class="dd-handle">
                            <label id="lbl">Home</label> <a id="destino" href="#">#</a>
                        </div>
                    </li>
                </ol>
            </div>   		
    		<div class="dd" id="nestable2">
                <ol class="dd-list">
                    <li class="dd-item" data-id="9999">
                        <div class="dd-handle">Recycled</div>
                    </li>
                </ol>
            </div> 
    
        </div>
        <table class="tableresults">
            <tr>
                <td>
                    <p><strong>List HTML code</strong></p>
                    <textarea id="nestable-output" style="font-size:12px;"></textarea>            
                </td>
                <td>
                    <p><strong>One XML representation</strong></p>
                    <textarea id="nestable-xml" style="font-size:12px;"></textarea>            
                </td>
            </tr>
        </table>
        <p><strong>Result Menu</strong></p>
        <button type="button" id="bntsavemenu">Save to default application menu</button>
        <button type="button" id="bntexit">Exit to main index.</button>
       <div id="resultado">
        </div>           
    </form>
</html>