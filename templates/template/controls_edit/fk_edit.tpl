<select name="{$value@key}" class="jq-combo" linkfields="{$value.linkfields}" id="{$value@key}" >
    {html_options values=$value.indices output=$value.etiquetas selected=$value.valor}
</select>
