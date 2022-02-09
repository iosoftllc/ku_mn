package iosf.com.support.taglib;

import java.io.IOException;
import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.jsp.JspException;
import javax.servlet.jsp.JspWriter;
import javax.servlet.jsp.tagext.SimpleTagSupport;

import org.apache.commons.lang3.StringUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.web.context.request.RequestContextHolder;
import org.springframework.web.context.request.ServletRequestAttributes;
import org.springframework.web.servlet.support.RequestContextUtils;

import com.ibm.icu.util.Calendar;

public class DateTag extends SimpleTagSupport {

	private final Logger logger = LoggerFactory.getLogger(getClass());

	private String format;
	private String value;
	private String default_value;
	private String calc_year;
	private String calc_month;
	private String calc_day;
	private String calc_hour;
	private String calc_min;
	private String calc_sec;
	private String week;

	@Override
	public void doTag() throws JspException, IOException {
		// TODO Auto-generated method stub
		logger.debug("		:: Tag Library : Date :: ");
		JspWriter out = getJspContext().getOut();
		HttpServletRequest req = ((ServletRequestAttributes) RequestContextHolder.getRequestAttributes()).getRequest();

		if (StringUtils.isEmpty(value) && !StringUtils.isEmpty(default_value)) {
			if ("today".equals(default_value)) {
				DateFormat df = new SimpleDateFormat("yyyyMMddHHmmss");
				Calendar cal = Calendar.getInstance();
				Date d = cal.getTime();
				value = df.format(d);
			}
		}

		if (StringUtils.isEmpty(value) || (value.length() != 14 && value.length() != 8)) {
			if (!StringUtils.isEmpty(default_value)) {
				value = default_value;
			}
			super.doTag();
			return;
		}

		try {
			DateFormat df = new SimpleDateFormat("yyyyMMddHHmmss");
			Date d = df.parse(value.length() > 8 ? value : (value + "000000"));

			DateFormat _df = new SimpleDateFormat(format, RequestContextUtils.getLocale(req));
			Calendar cal = Calendar.getInstance();
			// 월요일 시작 기준
			cal.setFirstDayOfWeek(Calendar.MONDAY);
			cal.setTime(d);
			if (!StringUtils.isEmpty(week)) {
				int _week = Calendar.MONDAY;
				if ("MON".equalsIgnoreCase(week)) {
					_week = Calendar.MONDAY;
				} else if ("TUE".equalsIgnoreCase(week)) {
					_week = Calendar.TUESDAY;
				} else if ("WED".equalsIgnoreCase(week)) {
					_week = Calendar.WEDNESDAY;
				} else if ("THU".equalsIgnoreCase(week)) {
					_week = Calendar.THURSDAY;
				} else if ("FRI".equalsIgnoreCase(week)) {
					_week = Calendar.FRIDAY;
				} else if ("SAT".equalsIgnoreCase(week)) {
					_week = Calendar.SATURDAY;
				} else if ("SUN".equalsIgnoreCase(week)) {
					_week = Calendar.SUNDAY;
				}
				cal.set(Calendar.DAY_OF_WEEK, _week);
			}
			if (!StringUtils.isEmpty(calc_year)) {
				cal.add(Calendar.YEAR, Integer.parseInt(calc_year));
			}
			if (!StringUtils.isEmpty(calc_month)) {
				cal.add(Calendar.MONTH, Integer.parseInt(calc_month));
			}
			if (!StringUtils.isEmpty(calc_day)) {
				cal.add(Calendar.DATE, Integer.parseInt(calc_day));
			}
			if (!StringUtils.isEmpty(calc_hour)) {
				cal.add(Calendar.HOUR, Integer.parseInt(calc_hour));
			}
			if (!StringUtils.isEmpty(calc_min)) {
				cal.add(Calendar.MINUTE, Integer.parseInt(calc_min));
			}
			if (!StringUtils.isEmpty(calc_sec)) {
				cal.add(Calendar.SECOND, Integer.parseInt(calc_sec));
			}
			d = cal.getTime();
			out.print(_df.format(d));
		} catch (ParseException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}

		super.doTag();
	}

	/**
	 * @return the format
	 */
	public String getFormat() {
		return format;
	}

	/**
	 * @param format the format to set
	 */
	public void setFormat(String format) {
		this.format = format;
	}

	/**
	 * @return the value
	 */
	public String getValue() {
		return value;
	}

	/**
	 * @param value the value to set
	 */
	public void setValue(String value) {
		this.value = value;
	}

	/**
	 * @return the default_value
	 */
	public final String getDefault_value() {
		return default_value;
	}

	/**
	 * @param default_value the default_value to set
	 */
	public final void setDefault_value(String default_value) {
		this.default_value = default_value;
	}

	/**
	 * @return the calc_day
	 */
	public final String getCalc_day() {
		return calc_day;
	}

	/**
	 * @param calc_day the calc_day to set
	 */
	public final void setCalc_day(String calc_day) {
		this.calc_day = calc_day;
	}

	/**
	 * @return the week
	 */
	public final String getWeek() {
		return week;
	}

	/**
	 * @param week the week to set
	 */
	public final void setWeek(String week) {
		this.week = week;
	}

	/**
	 * @return the calc_year
	 */
	public final String getCalc_year() {
		return calc_year;
	}

	/**
	 * @param calc_year the calc_year to set
	 */
	public final void setCalc_year(String calc_year) {
		this.calc_year = calc_year;
	}

	/**
	 * @return the calc_month
	 */
	public final String getCalc_month() {
		return calc_month;
	}

	/**
	 * @param calc_month the calc_month to set
	 */
	public final void setCalc_month(String calc_month) {
		this.calc_month = calc_month;
	}

	/**
	 * @return the calc_hour
	 */
	public final String getCalc_hour() {
		return calc_hour;
	}

	/**
	 * @param calc_hour the calc_hour to set
	 */
	public final void setCalc_hour(String calc_hour) {
		this.calc_hour = calc_hour;
	}

	/**
	 * @return the calc_min
	 */
	public final String getCalc_min() {
		return calc_min;
	}

	/**
	 * @param calc_min the calc_min to set
	 */
	public final void setCalc_min(String calc_min) {
		this.calc_min = calc_min;
	}

	/**
	 * @return the calc_sec
	 */
	public final String getCalc_sec() {
		return calc_sec;
	}

	/**
	 * @param calc_sec the calc_sec to set
	 */
	public final void setCalc_sec(String calc_sec) {
		this.calc_sec = calc_sec;
	}

}