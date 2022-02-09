package iosf.com.support.taglib;

import java.io.IOException;
import java.util.HashMap;
import java.util.Map;

import javax.servlet.jsp.JspException;
import javax.servlet.jsp.JspWriter;
import javax.servlet.jsp.tagext.SimpleTagSupport;

import org.apache.commons.lang.StringUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import iosf.com.support.util.Functions;

public class ButtonTag extends SimpleTagSupport {

	private final Logger logger = LoggerFactory.getLogger(getClass());

	private String id;
	private String type;
	private String btnType;
	private String style;
	private String onclick;
	private String value;
	private String color;
	private String clazz;
	private String icon;
	private String disabled;
	private String permission;
	private String set;
	private boolean bDisabled;
	private boolean bPermission;

	@Override
	public void doTag() throws JspException, IOException {
		// TODO Auto-generated method stub
		logger.debug("		:: Tag Library : Button");
		JspWriter out = getJspContext().getOut();
		String html = "";

		if (StringUtils.isEmpty(permission) || !"false".equals(permission)) {
			bPermission = true;
		} else {
			bPermission = false;
		}

		if (StringUtils.isEmpty(disabled) || !"true".equals(disabled)) {
			bDisabled = false;
		} else {
			bDisabled = true;
		}

		if (!bPermission) {
			out.print(html);
			super.doTag();
			return;
		}

		if (!StringUtils.isEmpty(set)) {
			String _color = "white";
			String _icon = set;

			if ("list".equalsIgnoreCase(set)) {
				_icon = "list1";
			} else if ("save".equalsIgnoreCase(set)) {
				_color = "red";
				_icon = "save1";
			} else if ("tempsave".equalsIgnoreCase(set)) {
				_icon = "save2";
			} else if ("delete".equalsIgnoreCase(set)) {
			} else if ("write".equalsIgnoreCase(set)) {
			} else if ("rewrite".equalsIgnoreCase(set)) {
				_icon = "write";
			} else if ("modify".equalsIgnoreCase(set)) {
			} else if ("close".equalsIgnoreCase(set)) {
				_icon = "cancel";
			} else if ("cancel".equalsIgnoreCase(set)) {
				_color = "pinkred";
			} else if ("confirm".equalsIgnoreCase(set)) {
				_color = "red";
				_icon = "select";
			} else if ("search".equalsIgnoreCase(set)) {
				_color = "red";
			} else if ("reject".equalsIgnoreCase(set)) {
				_color = "pinkred";
				_icon = "option";
			} else if ("download".equalsIgnoreCase(set)) {
				_color = "darkbeige";
			} else if ("upload".equalsIgnoreCase(set)) {
				_color = "orange";
			} else if ("reset".equalsIgnoreCase(set)) {
				_color = "grey";
			} else if ("plus".equalsIgnoreCase(set)) {
				_color = "darkbeige";
			} else if ("minus".equalsIgnoreCase(set)) {
				_color = "darkbeige";
			} else if ("refresh".equalsIgnoreCase(set)) {
				_color = "grey";
				_icon = "reset";
			}

			if (StringUtils.isEmpty(color)) {
				color = _color;
			}

			if (StringUtils.isEmpty(icon)) {
				icon = _icon;
			}
		}

		Map<String, Object> map = new HashMap<String, Object>();
		map.put("type", type);
		map.put("id", id);
		map.put("btnType", btnType);
		map.put("style", style);
		map.put("onclick", onclick);
		map.put("icon", icon);
		map.put("color", color);
		map.put("clazz", clazz);
		map.put("value", value);
		map.put("disabled", bDisabled);

		try {
			html = Functions.getComponents("button", map);
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}

		out.print(html);

		super.doTag();
	}

	/**
	 * @return the type
	 */
	public final String getType() {
		return type;
	}

	/**
	 * @param type
	 *            the type to set
	 */
	public final void setType(String type) {
		this.type = type;
	}

	/**
	 * @return the btnType
	 */
	public final String getBtnType() {
		return btnType;
	}

	/**
	 * @param btnType
	 *            the btnType to set
	 */
	public final void setBtnType(String btnType) {
		this.btnType = btnType;
	}

	/**
	 * @return the style
	 */
	public final String getStyle() {
		return style;
	}

	/**
	 * @param style
	 *            the style to set
	 */
	public final void setStyle(String style) {
		this.style = style;
	}

	/**
	 * @return the onclick
	 */
	public final String getOnclick() {
		return onclick;
	}

	/**
	 * @param onclick
	 *            the onclick to set
	 */
	public final void setOnclick(String onclick) {
		this.onclick = onclick;
	}

	/**
	 * @return the value
	 */
	public final String getValue() {
		return value;
	}

	/**
	 * @param value
	 *            the value to set
	 */
	public final void setValue(String value) {
		this.value = value;
	}

	/**
	 * @return the color
	 */
	public final String getColor() {
		return color;
	}

	/**
	 * @param color
	 *            the color to set
	 */
	public final void setColor(String color) {
		this.color = color;
	}

	/**
	 * @return the clazz
	 */
	public final String getClazz() {
		return clazz;
	}

	/**
	 * @param clazz
	 *            the clazz to set
	 */
	public final void setClazz(String clazz) {
		this.clazz = clazz;
	}

	/**
	 * @return the icon
	 */
	public final String getIcon() {
		return icon;
	}

	/**
	 * @param icon
	 *            the icon to set
	 */
	public final void setIcon(String icon) {
		this.icon = icon;
	}

	/**
	 * @return the disabled
	 */
	public final String getDisabled() {
		return disabled;
	}

	/**
	 * @param disabled
	 *            the disabled to set
	 */
	public final void setDisabled(String disabled) {
		this.disabled = disabled;
	}

	/**
	 * @return the permission
	 */
	public final String getPermission() {
		return permission;
	}

	/**
	 * @param permission
	 *            the permission to set
	 */
	public final void setPermission(String permission) {
		this.permission = permission;
	}

	/**
	 * @return the bDisabled
	 */
	public final boolean isbDisabled() {
		return bDisabled;
	}

	/**
	 * @param bDisabled
	 *            the bDisabled to set
	 */
	public final void setbDisabled(boolean bDisabled) {
		this.bDisabled = bDisabled;
	}

	/**
	 * @return the bPermission
	 */
	public final boolean isbPermission() {
		return bPermission;
	}

	/**
	 * @param bPermission
	 *            the bPermission to set
	 */
	public final void setbPermission(boolean bPermission) {
		this.bPermission = bPermission;
	}

	/**
	 * @return the set
	 */
	public final String getSet() {
		return set;
	}

	/**
	 * @param set
	 *            the set to set
	 */
	public final void setSet(String set) {
		this.set = set;
	}

	/**
	 * @return the id
	 */
	public final String getId() {
		return id;
	}

	/**
	 * @param id
	 *            the id to set
	 */
	public final void setId(String id) {
		this.id = id;
	}

}