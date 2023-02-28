<tr>
    <td>{$value[4]}:</td>
    <td>
        <select name="{$value@key}" class="jq-combo">
            {html_options values=$value[1] output=$value[0] }
        </select>
    </td>
</tr>