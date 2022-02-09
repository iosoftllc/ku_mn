<button type="${type}" class="common-btn${btnType}<#if !value?has_content>_3</#if> <#if color?has_content><#if value?has_content>btn-</#if>${color}<#else>btn-white</#if> <#if clazz?has_content>${clazz}</#if>" <#if onclick?has_content>onclick="${onclick}"</#if> <#if style?has_content>style="${style}"</#if> <#if disabled>disabled="disabled"</#if> <#if id?has_content>id="${id}"</#if>>
	<span class="btn-icon-holder">
	 	<#if icon?has_content>
			<span class="icon-holder">
				<span class="btn${btnType}-icon ${icon}">&nbsp;</span>
			</span>
		</#if>
	 	<#if value?has_content>
			<span class="btn-text">${value}</span>
		</#if>
	</span>
</button>