package iosf.com.support.taglib;

import java.io.IOException;

import javax.servlet.jsp.JspException;
import javax.servlet.jsp.JspWriter;
import javax.servlet.jsp.tagext.SimpleTagSupport;

import org.apache.commons.lang3.StringUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import iosf.com.support.util.Functions;
import lombok.Getter;
import lombok.Setter;

@Setter
@Getter
public class CodeTag extends SimpleTagSupport {

	private final Logger logger = LoggerFactory.getLogger(getClass());

	private String upcd;
	private String cd;
	private String conjunction;
	private Boolean lang;

	@Override
	public void doTag() throws JspException, IOException {
		// TODO Auto-generated method stub
		logger.debug("		:: Tag Library : Code");
		JspWriter out = getJspContext().getOut();

		String html = "";

		if (lang == null) {
			lang = false;
		}

		try {
			if (!StringUtils.isEmpty(cd)) {
				if (StringUtils.isEmpty(conjunction)) {
					if (!lang) {
						html = Functions.getCode(upcd, cd);
					} else {
						html = Functions.getMessage("code." + upcd + "." + cd);
					}
				} else {
					for (int i = 0; i < cd.split(conjunction).length; i++) {
						html += (StringUtils.isEmpty(html) ? "" : ", ") + Functions.getCode(upcd, cd.split(conjunction)[i]);
					}
				}
				if (StringUtils.isEmpty(html)) {
					throw new Exception("code not found");
				}
			}
			out.print(html);
		} catch (Exception e) {
			// TODO Auto-generated catch block
			out.print(Functions.getMessage("errors.code.notfound") + " : " + cd);
			e.printStackTrace();
		}

		super.doTag();
	}
}