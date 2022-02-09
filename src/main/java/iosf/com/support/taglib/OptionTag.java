package iosf.com.support.taglib;

import java.io.IOException;
import java.util.Iterator;
import java.util.LinkedHashMap;
import java.util.List;
import java.util.Map;
import java.util.Map.Entry;

import javax.servlet.jsp.JspException;
import javax.servlet.jsp.JspWriter;
import javax.servlet.jsp.tagext.SimpleTagSupport;

import org.apache.commons.lang.StringUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import iosf.com.support.util.Functions;
import lombok.Getter;
import lombok.Setter;

@Getter
@Setter
public class OptionTag extends SimpleTagSupport {

	private final Logger logger = LoggerFactory.getLogger(getClass());

	private Object object;
	private String select;
	private String enabledCondition;
	private Boolean disabled;
	private String clazzCondition;
	private String clazz;
	private String exception;
	private String lang_up_cd;

	@SuppressWarnings("unchecked")
	@Override
	public void doTag() throws JspException, IOException {
		// TODO Auto-generated method stub
		logger.debug("		:: Tag Library : Option");
		JspWriter out = getJspContext().getOut();

		String html = "";

		if (StringUtils.isEmpty(select)) {
			select = "";
		}
		
		if (StringUtils.isEmpty(clazzCondition)) {
			clazzCondition = "";
		}
		
		if (StringUtils.isEmpty(clazz)) {
			clazz = "";
		}
		
		if (StringUtils.isEmpty(enabledCondition)) {
			enabledCondition = "";
		}
		
		if (disabled == null) {
			disabled = false;
		}

		if (StringUtils.isEmpty(lang_up_cd)) {
			lang_up_cd = "";
		}
		
		boolean bExcept = false;
		logger.debug("		:: Option Exception : " + exception);
		if (object instanceof LinkedHashMap) {
			for (Entry<String, String> el : ((LinkedHashMap<String, String>) object).entrySet()) {
				String value = "".equals(lang_up_cd) ? Functions.getMessage(el.getValue()) : Functions.getMessage("code." + lang_up_cd + "." + el.getKey());
				logger.debug("		:: Option : " + ((select.equals(el.getKey())) ? "[SELECTED]" : "") + " " + ((disabled && !enabledCondition.contains(el.getKey())) ? "[DISABLED]" : "") +  " [KEY] " + el.getKey() + "		[VALUE] " + value);

				if (!StringUtils.isEmpty(exception)) {
					String[] e = exception.split(";");
					for (int i = 0; i < e.length; i++) {
						bExcept = false;
						if (el.getKey().equals(e[i])) {
							bExcept = true;
							break;
						}
					}
					if (bExcept) {
						continue;
					}
				}
				html += "<option value=\"" + el.getKey() + "\" " + ((select.equals(el.getKey())) ? "selected=\"selected\"" : "") + " " + ((clazzCondition.contains(el.getKey())) ? "class=\"" + clazz + "\"" : "") + " " + ((disabled && !enabledCondition.contains(el.getKey())) ? "disabled=\"disabled\"" : "") + ">" + value + "</option>";
			}
		} else if (object instanceof Map) {
			for (Entry<String, String> el : ((Map<String, String>) object).entrySet()) {
				String value = "".equals(lang_up_cd) ? Functions.getMessage(el.getValue()) : Functions.getMessage("code." + lang_up_cd + "." + el.getKey());
				logger.debug("		:: Option : " + ((select.equals(el.getKey())) ? "[SELECTED]" : "") + " " + ((disabled && !enabledCondition.contains(el.getKey())) ? "[DISABLED]" : "") + " [KEY] " + el.getKey() + "		[VALUE] " + value);
				
				if (!StringUtils.isEmpty(exception)) {
					String[] e = exception.split(";");
					for (int i = 0; i < e.length; i++) {
						bExcept = false;
						if (el.getKey().equals(e[i])) {
							bExcept = true;
							break;
						}
					}
					if (bExcept) {
						continue;
					}
				}
				html += "<option value=\"" + el.getKey() + "\" " + ((select.equals(el.getKey())) ? "selected=\"selected\"" : "") + " " + ((clazzCondition.contains(el.getKey())) ? "class=\"" + clazz + "\"" : "") + " " + ((disabled && !enabledCondition.contains(el.getKey())) ? "disabled=\"disabled\"" : "") + ">" + value + "</option>";
			}
		} else if (object instanceof List) {
			Iterator<String> el = ((List<String>) object).iterator();
			while (el.hasNext()) {
				String value = "".equals(lang_up_cd) ? Functions.getMessage(el.next()) : Functions.getMessage("code." + lang_up_cd + "." + el.next());
				logger.debug("		:: Option : " + ((select.equals(el.next())) ? "[SELECTED]" : "") + " " + ((disabled && !enabledCondition.contains(el.next())) ? "[DISABLED]" : "") + " [KEY] " + el.next() + "		[VALUE] " + value);

				if (!StringUtils.isEmpty(exception)) {
					String[] e = exception.split(";");
					for (int i = 0; i < e.length; i++) {
						bExcept = false;
						if (el.next().equals(e[i])) {
							bExcept = true;
							break;
						}
					}
					if (bExcept) {
						continue;
					}
				}
				html += "<option value=\"" + el.next() + "\" " + ((select.equals(el.next())) ? "selected=\"selected\"" : "") + " " + ((clazzCondition.contains(el.next())) ? "class=\"" + clazz + "\"" : "") + " " + ((disabled && !enabledCondition.contains(el.next())) ? "disabled=\"disabled\"" : "") + ">" + value + "</option>";
			}
		}

		out.print(html);
		super.doTag();
	}
}