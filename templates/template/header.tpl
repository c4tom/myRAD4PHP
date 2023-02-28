<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
        <link href="{$rutabase}css/default.css" rel="stylesheet" type="text/css" />
        <link href="{$rutabase}css/style.css" rel="stylesheet" type="text/css" />
        <link href="{$rutabase}css/jquery-ui.css" rel="stylesheet" type="text/css" />
        <script src="{$rutabase}scripts/rutabase.js"></script>
        <script type="text/javascript" src="{$rutabase}scripts/jquery-1.9.1.js"></script>
        <script type="text/javascript" src="{$rutabase}scripts/jquery-ui.js"></script>
        <script type="text/javascript" src="{$rutabase}swdd/scripts/genericos.js"></script>
        <script type="text/javascript" src="{$rutabase}swdd/scripts/{$tabla}.js"></script>
        <link rel="stylesheet" type="text/css" href="{$rutabase}css/ddlevelsfiles/ddlevelsmenu-base.css" />
        <link rel="stylesheet" type="text/css" href="{$rutabase}css/ddlevelsfiles/ddlevelsmenu-topbar.css" />
        <link rel="stylesheet" type="text/css" href="{$rutabase}css/ddlevelsfiles/ddlevelsmenu-sidebar.css" />
        <link rel="stylesheet" type="text/css" href="{$rutabase}css/mnubuilder.css" />
        
        
        <script src="{$rutabase}scripts/mnubuillder.js"></script>
        <script type="text/javascript" src="{$rutabase}scripts/ddlevelsmenu.js">

        /***********************************************
        * All Levels Navigational Menu- (c) Dynamic Drive DHTML code library (http://www.dynamicdrive.com)
        * This notice MUST stay intact for legal use
        * Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
        ***********************************************/
        
        </script>
        <style>
  .ui-combobox {
    position: relative;
    display: inline-block;
  }
  .ui-combobox-toggle {
    position: absolute;
    top: 0;
    bottom: 0;
    margin-left: -1px;
    padding: 0;
    /* support: IE7 */
    *height: 1.7em;
    *top: 0.1em;
  }
  .ui-combobox-input {
    margin: 0;
    padding: 0.3em;
  }
  </style>
    </head>
    <body>
        <div class="page">
            <div class="header">
                <div class="title">
                    <h1>
                        {$app_name}
                    </h1>
                </div>
                
                <div class="loginDisplay">
                
                    <table >
                        <tr>
                            <td>
                                
                            </td>
                            <td>
                                {if $nomuser|count_characters ne 0 }
                                <span class="spanlogin">{$userlabel}: {$nomuser}<br /></span>
                                <span class="spanlogin">{$datelabel}: {$smarty.now|date_format:"%D"}<br /></span>
                                
                                <a href="{$rutabase}login.php" class="jq-link" style="color:black;">{$logoutlabel}</a>
                                
                                {/if}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="clear hideSkiplink">
                    {if $nomuser|count_characters ne 0 }
                    <div id="ddtopmenubar" class="mainmenu">
                        {$menu}                        
                    </div>
                    
                    <script type="text/javascript">
                    ddlevelsmenu.setup("ddtopmenubar", "topbar") 
                    </script>
                    {/if}
                </div>
            </div>