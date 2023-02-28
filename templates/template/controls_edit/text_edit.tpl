{if $value.tamanio lt 50}
    <input type="text" name="{$value.nombre}" value="{$value.valor}" size="{$value.tamanio}" class="DDTextBox"  id="{$value@key}"  linkfields="{$value.linkfields}"/>
{else}
    <textarea name="{$value.nombre}" rows="5" cols="80"  id="{$value@key}" linkfields="{$value.linkfields}">{$value.valor}</textarea>
{/if}

