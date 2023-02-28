<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
        <link href="{$rutabase}css/default.css" rel="stylesheet" type="text/css" />
        <link href="{$rutabase}css/style.css" rel="stylesheet" type="text/css" />
        <link href="{$rutabase}css/jquery-ui.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="{$rutabase}scripts/jquery-1.9.1.js"></script>
        <script type="text/javascript" src="{$rutabase}scripts/jquery-ui.js"></script>
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
    <style>
table.DDGridView, table.DDListView
{
	width: 100%;
	color: black;
	border:solid 1px black;
    border-collapse: collapse;
	font: .9em Tahoma, Arial, Sans-Serif;
}



table.DDGridView .th, table.DDGridView .td, table.DDListView .th, table.DDListView .td
{
	white-space: nowrap;
}

table.DDGridView .th, table.DDListView .th
{
	line-height:1.3em;
	text-align: left;
	font-size: 1em;
	border:solid 1px black;
    background-color:white;
    padding: 6px;
    font-weight: bold;
    text-transform: uppercase;
}

table.DDGridView .th a, table.DDListView .th a
{
	color: black;
	text-decoration: none;
	text-transform:capitalize;
    border: solid 1px black;
}

table.DDGridView .td, table.DDListView .td
{
	border: solid 1px black;
	padding: 6px;
}

table.DDGridView .td a, table.DDListView .td a
{
	color: black;
    text-decoration: none;
    margin-right: 6px;
	
}

table.DDGridView .DDSelected a, table.DDListView .DDSelected a
{
	color: black;
    text-decoration: none;
    margin-right: 6px;
	
}

table.DDGridView .DDSelected a:hover, table.DDListView .DDSelected a:hover
{
	color: black;
	text-decoration: underline;
}

table.DDGridView .td a:hover, table.DDListView .td a:hover
{
	color: black;
	text-decoration: underline;
}

  </style>
    </head>
    <body>
        
                    <h1>
                        {$app_name}
                    </h1>
        
                    <table >
                        <tr>
                            <td>
                                
                            </td>
                            <td>
                                {if $nomuser|count_characters ne 0 }
                                {$userlabel}: {$nomuser}<br />
                                {$datelabel}: {$smarty.now|date_format:"%D"}<br />
                                {/if}
                            </td>
                        </tr>
                    </table>
                
                <h1 >{$titlelist} {$tabla}</h1>
                
                        <table>                       
                            {foreach $filtros as $filtro}
                                {foreach $filtro as $value}
                                    {if $value[3] neq ""}
                                    <tr>
                                        <td>{$value[4]}: </td>
                                        <td>{$value[5]}</td>
                                    </tr>
                                    {/if}
                                {/foreach}
                            {/foreach}
                        </table>
                
                
                <br />
                    {html_table loop=$data cols=$columnames table_attr='class="DDGridView"' th_attr='class="th"' td_attr=$td}                 
            
    </body>
</html>