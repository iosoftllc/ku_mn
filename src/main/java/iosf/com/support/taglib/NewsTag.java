package iosf.com.support.taglib;

import java.io.IOException;
import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;

import javax.servlet.jsp.JspException;
import javax.servlet.jsp.JspWriter;
import javax.servlet.jsp.tagext.SimpleTagSupport;

import org.apache.commons.lang.StringUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import iosf.com.sys.Configs;

public class NewsTag extends SimpleTagSupport {

	private final Logger logger = LoggerFactory.getLogger(getClass());

	private String datetime;
	private String period;

	@Override
	public void doTag() throws JspException, IOException {
		// TODO Auto-generated method stub
		logger.debug("		:: Tag Library : News");
		JspWriter out = getJspContext().getOut();

		if (StringUtils.isEmpty(period)) {
			period = "" + Configs.NEW_DAY;
		}

		try {
			DateFormat df = new SimpleDateFormat("yyyyMMddHHmmss");
			Date dt = df.parse(datetime);
			Calendar _pdt = Calendar.getInstance();
			_pdt.setTime(dt);
			Calendar pdt = Calendar.getInstance();
			pdt.add(Calendar.DATE, Integer.parseInt(period));

			if (pdt.getTimeInMillis() <= _pdt.getTimeInMillis()) {
				out.print("<span class=\"etc_icon icon_list new\">new</span>");
			}
		} catch (ParseException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}

		super.doTag();
	}

	/**
	 * @return the datetime
	 */
	public String getDatetime() {
		return datetime;
	}

	/**
	 * @param datetime
	 *            the datetime to set
	 */
	public void setDatetime(String datetime) {
		this.datetime = datetime;
	}

	/**
	 * @return the period
	 */
	public String getPeriod() {
		return period;
	}

	/**
	 * @param period
	 *            the period to set
	 */
	public void setPeriod(String period) {
		this.period = period;
	}
}