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

public class CheckboxTag extends SimpleTagSupport {

	private final Logger logger = LoggerFactory.getLogger(getClass());

	private Object value;
	private String label;
	private String name;
	private String id;
	private String onclick;
	private String check;
	private String style;
	private String className;
	private String exception;
	private String disabled;
	private String checked;
	private String permission;
	private String permissionshow;
	private boolean bDisabled;
	private boolean bChecked;
	private boolean bPermission;
	private boolean bPermissionshow;

	@SuppressWarnings("unchecked")
	@Override
	public void doTag() throws JspException, IOException {
		// TODO Auto-generated method stub
		logger.debug("		:: Tag Library : Checkbox");
		JspWriter out = getJspContext().getOut();

		String html = "";
		if (StringUtils.isEmpty(disabled) || "false".equals(disabled)) {
			bDisabled = false;
		} else {
			bDisabled = true;
		}
		if (StringUtils.isEmpty(checked) || "false".equals(checked)) {
			bChecked = false;
		} else {
			bChecked = true;
		}
		if (StringUtils.isEmpty(permission) || !"false".equals(permission)) {
			bPermission = true;
		} else {
			bPermission = false;
		}
		if (StringUtils.isEmpty(permissionshow) || "false".equals(permissionshow)) {
			bPermissionshow = false;
		} else {
			bPermissionshow = true;
		}

		if (!bPermission) {
			if (!bPermissionshow) {
				out.print(html);
				super.doTag();
				return;
			}
		}
		if (StringUtils.isEmpty(check)) {
			check = "";
		}
		if (!StringUtils.isEmpty(style)) {
			style = " style=\"" + style + "\"";
		} else {
			style = "";
		}
		if (!StringUtils.isEmpty(className)) {
			className = " class=\"" + className + "\"";
		} else {
			className = "";
		}
		if (!StringUtils.isEmpty(onclick)) {
			onclick = " onclick=\"" + onclick + "\"";
		} else {
			onclick = "";
		}

		boolean bExcept = false;
		logger.debug("		:: Checkbox Exception : " + exception);

		html += "<div class=\"controlobj-group\">";

		if (value instanceof LinkedHashMap) {
			for (Entry<String, String> el : ((LinkedHashMap<String, String>) value).entrySet()) {
				String key = el.getKey();
				String val = el.getValue();

				logger.debug("		:: Checkbox : " + ((check.equals(el.getKey()) || bChecked) ? "[CHECKED]" : "") + " [KEY] " + key + "		[VALUE] " + Functions.getMessage(val));

				if (!StringUtils.isEmpty(exception)) {
					String[] e = exception.split(";");
					for (int i = 0; i < e.length; i++) {
						if (key.equals(e[i])) {
							bExcept = true;
							continue;
						}
					}
					if (bExcept) {
						continue;
					}
				}

				html += "";
				html += "<label class=\"etc_controlobj\"><input type=\"checkbox\" name=\"" + name + "\" id=\"" + (name + key) + "\" value=\"" + key + "\" " + style + className + onclick + ((check.contains(key) || bChecked) ? " checked=\"checked\"" : "") + ((!bPermission || bDisabled) ? " disabled=\"disabled\"" : "") + " title=\"" + Functions.getMessage((String) val) + Functions.getMessage("선택") + "\" /><span></span> " + Functions.getMessage(val) + "</label>";
				html += "";
			}
		} else if (value instanceof Map) {
			for (Entry<String, String> el : ((Map<String, String>) value).entrySet()) {
				String key = el.getKey();
				String val = el.getValue();

				logger.debug("		:: Checkbox : " + ((check.equals(el.getKey()) || bChecked) ? "[CHECKED]" : "") + " [KEY] " + key + "		[VALUE] " + Functions.getMessage(val));

				if (!StringUtils.isEmpty(exception)) {
					String[] e = exception.split(";");
					for (int i = 0; i < e.length; i++) {
						if (key.equals(e[i])) {
							bExcept = true;
							continue;
						}
					}
					if (bExcept) {
						continue;
					}
				}

				html += "";
				html += "<label class=\"etc_controlobj\"><input type=\"checkbox\" name=\"" + name + "\" id=\"" + (name + key) + "\" value=\"" + key + "\" " + style + className + onclick + ((check.contains(key) || bChecked) ? " checked=\"checked\"" : "") + ((!bPermission || bDisabled) ? " disabled=\"disabled\"" : "") + " title=\"" + Functions.getMessage((String) val) + Functions.getMessage("선택") + "\" /><span></span> " + Functions.getMessage(val) + "</label>";
				html += "";
			}
		} else if (value instanceof List) {
			Iterator<String> el = ((List<String>) value).iterator();
			while (el.hasNext()) {
				String val = el.next();

				logger.debug("		:: Checkbox : " + ((check.equals(val) || bChecked) ? "[CHECKED]" : "") + " [KEY] " + val + "		[VALUE] " + Functions.getMessage(val));

				if (!StringUtils.isEmpty(exception)) {
					String[] e = exception.split(";");
					for (int i = 0; i < e.length; i++) {
						if (val.equals(e[i])) {
							bExcept = true;
							continue;
						}
					}
					if (bExcept) {
						continue;
					}
				}

				html += "";
				html += "<label class=\"etc_controlobj\"><input type=\"checkbox\" name=\"" + name + "\" id=\"" + (name + val) + "\" value=\"" + val + "\" " + style + className + onclick + ((check.equals(val) || bChecked) ? " checked=\"checked\"" : "") + ((!bPermission || bDisabled) ? " disabled=\"disabled\"" : "") + " title=\"" + Functions.getMessage((String) val) + Functions.getMessage("선택") + "\" /><span></span> " + Functions.getMessage((String) val) + "</label>";
				html += "";
			}
		} else if (value instanceof String) {
			if (!StringUtils.isEmpty(name)) {
				name = " name=\"" + name + "\"";
			} else {
				name = "";
			}
			if (!StringUtils.isEmpty(id)) {
				id = " id=\"" + id + "\"";
			} else {
				id = "";
			}
			if (StringUtils.isEmpty((String) value)) {
				value = "";
			}
			logger.debug("		:: Checkbox : " + ((check.equals(value) || bChecked) ? "[CHECKED]" : "") + " [KEY] " + value + "		[VALUE] " + value);
			html += "";
			html += "<label class=\"etc_controlobj\"><input type=\"checkbox\" " + name + id + " value=\"" + value + "\"" + style + className + onclick + ((check.equals(value) || bChecked) ? " checked=\"checked\"" : "") + ((!bPermission || bDisabled) ? " disabled=\"disabled\"" : "") + " title=\"" + Functions.getMessage((String) label) + Functions.getMessage("선택") + "\" /><span></span> " + Functions.getMessage((String) label) + "</label>";
			html += "";
		} else if (value instanceof Long) {
			if (!StringUtils.isEmpty(name)) {
				name = " name=\"" + name + "\"";
			} else {
				name = "";
			}
			if (!StringUtils.isEmpty(id)) {
				id = " id=\"" + id + "\"";
			} else {
				id = "";
			}
			if (StringUtils.isEmpty("" + value)) {
				value = "";
			}
			logger.debug("		:: Checkbox : " + ((check.equals(value) || bChecked) ? "[CHECKED]" : "") + " [KEY] " + value + "		[VALUE] " + value);
			html += "";
			html += "<label class=\"etc_controlobj\"><input type=\"checkbox\" " + name + id + " value=\"" + value + "\"" + style + className + onclick + ((check.equals(value) || bChecked) ? " checked=\"checked\"" : "") + ((!bPermission || bDisabled) ? " disabled=\"disabled\"" : "") + " title=\"" + Functions.getMessage((String) label) + Functions.getMessage("선택") + "\" /><span></span> " + Functions.getMessage((String) label) + "</label>";
			html += "";
		}

		html += "</div>";

		out.print(html);
		super.doTag();
	}

	/**
	 * @return the value
	 */
	public Object getValue() {
		return value;
	}

	/**
	 * @param value
	 *            the value to set
	 */
	public void setValue(Object value) {
		this.value = value;
	}

	/**
	 * @return the label
	 */
	public String getLabel() {
		return label;
	}

	/**
	 * @param label
	 *            the label to set
	 */
	public void setLabel(String label) {
		this.label = label;
	}

	/**
	 * @return the name
	 */
	public String getName() {
		return name;
	}

	/**
	 * @param name
	 *            the name to set
	 */
	public void setName(String name) {
		this.name = name;
	}

	/**
	 * @return the id
	 */
	public String getId() {
		return id;
	}

	/**
	 * @param id
	 *            the id to set
	 */
	public void setId(String id) {
		this.id = id;
	}

	/**
	 * @return the onclick
	 */
	public String getOnclick() {
		return onclick;
	}

	/**
	 * @param onclick
	 *            the onclick to set
	 */
	public void setOnclick(String onclick) {
		this.onclick = onclick;
	}

	/**
	 * @return the check
	 */
	public String getCheck() {
		return check;
	}

	/**
	 * @param check
	 *            the check to set
	 */
	public void setCheck(String check) {
		this.check = check;
	}

	/**
	 * @return the style
	 */
	public String getStyle() {
		return style;
	}

	/**
	 * @param style
	 *            the style to set
	 */
	public void setStyle(String style) {
		this.style = style;
	}

	/**
	 * @return the className
	 */
	public String getClassName() {
		return className;
	}

	/**
	 * @param className
	 *            the className to set
	 */
	public void setClassName(String className) {
		this.className = className;
	}

	/**
	 * @return the exception
	 */
	public String getException() {
		return exception;
	}

	/**
	 * @param exception
	 *            the exception to set
	 */
	public void setException(String exception) {
		this.exception = exception;
	}

	/**
	 * @return the disabled
	 */
	public String getDisabled() {
		return disabled;
	}

	/**
	 * @param disabled
	 *            the disabled to set
	 */
	public void setDisabled(String disabled) {
		this.disabled = disabled;
	}

	/**
	 * @return the checked
	 */
	public String getChecked() {
		return checked;
	}

	/**
	 * @param checked
	 *            the checked to set
	 */
	public void setChecked(String checked) {
		this.checked = checked;
	}

	/**
	 * @return the permission
	 */
	public String getPermission() {
		return permission;
	}

	/**
	 * @param permission
	 *            the permission to set
	 */
	public void setPermission(String permission) {
		this.permission = permission;
	}

	/**
	 * @return the permissionshow
	 */
	public String getPermissionshow() {
		return permissionshow;
	}

	/**
	 * @param permissionshow
	 *            the permissionshow to set
	 */
	public void setPermissionshow(String permissionshow) {
		this.permissionshow = permissionshow;
	}

	/**
	 * @return the bDisabled
	 */
	public boolean isbDisabled() {
		return bDisabled;
	}

	/**
	 * @param bDisabled
	 *            the bDisabled to set
	 */
	public void setbDisabled(boolean bDisabled) {
		this.bDisabled = bDisabled;
	}

	/**
	 * @return the bChecked
	 */
	public boolean isbChecked() {
		return bChecked;
	}

	/**
	 * @param bChecked
	 *            the bChecked to set
	 */
	public void setbChecked(boolean bChecked) {
		this.bChecked = bChecked;
	}

	/**
	 * @return the bPermission
	 */
	public boolean isbPermission() {
		return bPermission;
	}

	/**
	 * @param bPermission
	 *            the bPermission to set
	 */
	public void setbPermission(boolean bPermission) {
		this.bPermission = bPermission;
	}

	/**
	 * @return the bPermissionshow
	 */
	public boolean isbPermissionshow() {
		return bPermissionshow;
	}

	/**
	 * @param bPermissionshow
	 *            the bPermissionshow to set
	 */
	public void setbPermissionshow(boolean bPermissionshow) {
		this.bPermissionshow = bPermissionshow;
	}
}