package iosf.com.support.taglib;

import java.io.IOException;
import java.util.Locale;

import javax.servlet.jsp.JspException;
import javax.servlet.jsp.JspWriter;
import javax.servlet.jsp.tagext.SimpleTagSupport;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import iosf.com.support.util.Functions;
import lombok.Getter;
import lombok.Setter;

@Getter
@Setter
public class MessageTag extends SimpleTagSupport {

	private final Logger logger = LoggerFactory.getLogger(getClass());

	private String key;
	private String args;
	private Locale locale;

	@Override
	public void doTag() throws JspException, IOException {
		// TODO Auto-generated method stub
		logger.debug("		:: Tag Library : Message");
		JspWriter out = getJspContext().getOut();
		String html = key;
		html = Functions.getMessage(key, args, locale);
		out.print(html);

		super.doTag();
	}
}