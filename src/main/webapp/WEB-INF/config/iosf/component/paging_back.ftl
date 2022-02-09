<div class="obj-paging">
	<div>
		<span class="paging-left">
			<a href="${url}?current_page_no=1&amp;${param}" class="first" title="${first_title}">&nbsp;</a>
			<a href="${url}?current_page_no=${prev}&amp;${param}" class="prev" title="${prev_title}">&nbsp;</a>
		</span>
		<ul>
			<#list page_start..page_end as row>
				<li class="<#if (row?number == current_page?number)>now-page</#if>"><a href="${url}?current_page_no=${row}&amp;${param}" title="${row} ${page_title}">${row}</a></li>
			</#list>
		</ul>
		<span class="paging-right">
			<a href="${url}?current_page_no=${next}&amp;${param}" title="${next_title}" class="next">&nbsp;</a>
			<a href="${url}?current_page_no=${last}&amp;${param}" title="${last_title}" class="last">&nbsp;</a>
		</span>			
	</div>
</div>