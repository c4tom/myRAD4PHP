<tr>
    <td>
        {$value[4]}:
    </td>
    <td>
        <select name="{$value@key}" class="jq-combo" id="{$value@key}" >
            {html_options values=$value[1] output=$value[0] selected=$value[3] }
        </select>
    </td>
</tr>