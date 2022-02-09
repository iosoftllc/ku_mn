<div class="paging">
    <dl>
        <dt>
        	<button type="button" title="${first_title}" onclick="location.href = '${url}?current_page_no=1&amp;${param}';"></button>
        	<button type="button" title="${prev_title}" onciick="location.href = '${url}?current_page_no=${prev}&amp;${param}';"></button>
        </dt>
        <dd>
        	<#list page_start..page_end as row>
                <button type="button" class="<#if (row?number == current_page?number)>on</#if>" onclick="location.href = '${url}?current_page_no=${row}&amp;${param}';" title="${row} ${page_title}">${row}</button>
            </#list>
        </dd>
        <dd class="mobile">
            <p>${current_page}</p><small>/</small><p>${last}</p>
        </dd>
        <dt>
        	<button type="button" title="${next_title}" onclick="location.href = '${url}?current_page_no=${next}&amp;${param}';"></button>
        	<button type="button" title="${last_title}" onclick="location.href = '${url}?current_page_no=${last}&amp;${param}';"></button>
        </dt>
    </dl>
</div>
