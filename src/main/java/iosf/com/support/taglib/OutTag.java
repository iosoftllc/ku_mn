package iosf.com.support.taglib;

import java.io.IOException;

import javax.servlet.jsp.JspException;
import javax.servlet.jsp.JspWriter;
import javax.servlet.jsp.tagext.SimpleTagSupport;

import org.apache.commons.lang.StringUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import lombok.Getter;
import lombok.Setter;

public class OutTag extends SimpleTagSupport {

	private final Logger logger = LoggerFactory.getLogger(getClass());

	@Getter
	@Setter
	private String value;
	@Getter
	@Setter
	private boolean escapeXml;
	private String[][] noTagList = { { "#", "\\(", "\\)" }, { "&#35;", "&#40;", "&#41;" } };

	@Override
	public void doTag() throws JspException, IOException {
		// TODO Auto-generated method stub
		logger.debug("		:: Tag Library : Out");
		JspWriter out = getJspContext().getOut();

		if (StringUtils.isEmpty(this.value)) {
			out.print(this.value);
			return;
		}
		
		if (this.escapeXml) {
			out.print(this.value);
			return;
		}

		try {
			for (int i = 0; i < noTagList[0].length; i++) {
				String text = noTagList[1][i];
				this.value = this.value.replaceAll(text, noTagList[0][i]);
			}
			out.print(this.value);
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}

		super.doTag();
	}
}