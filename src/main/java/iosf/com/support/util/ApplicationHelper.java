package iosf.com.support.util;

import javax.servlet.ServletContext;

import org.springframework.web.context.WebApplicationContext;
import org.springframework.web.context.support.WebApplicationContextUtils;

public class ApplicationHelper {
	public static Object getService(String serviceName, ServletContext sc) {
		WebApplicationContext ctx = WebApplicationContextUtils.getWebApplicationContext(sc);

		return ctx.getBean(serviceName);
	}
}
