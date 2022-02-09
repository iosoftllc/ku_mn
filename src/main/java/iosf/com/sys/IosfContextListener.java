package iosf.com.sys;

import javax.servlet.ServletContext;
import javax.servlet.ServletContextEvent;
import javax.servlet.ServletContextListener;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

public class IosfContextListener implements ServletContextListener {

	private static final Logger LOGGER = LoggerFactory.getLogger(IosfContextListener.class);
	private ServletContext context;

	public synchronized void contextInitialized(ServletContextEvent contextEvent) {
		LOGGER.debug("			:: Context Initialized [start]");

		context = contextEvent.getServletContext();

		// System Initialized
		try {
			new Configs(context);
			new Codes(context);
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}

		LOGGER.debug("			:: Context Initialized [finish]");
	}

	public synchronized void contextDestroyed(ServletContextEvent contextEvent) {
		context = contextEvent.getServletContext();
		LOGGER.debug("			:: Context Destroyed");
	}
}
