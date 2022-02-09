package iosf.com.sys;

import java.util.HashMap;
import java.util.LinkedHashMap;
import java.util.Map;

import javax.servlet.ServletContext;
import javax.servlet.http.HttpServletRequest;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.web.context.request.RequestContextHolder;
import org.springframework.web.context.request.ServletRequestAttributes;

import iosf.com.program.code.service.CodeService;
import iosf.com.program.code.web.CodeCommand;
import iosf.com.support.util.ApplicationHelper;

public class Codes {

	private static final Logger LOGGER = LoggerFactory.getLogger(Codes.class);

	public Codes(ServletContext context) throws Exception {
		Map<String, LinkedHashMap<String, String>> codes = new HashMap<String, LinkedHashMap<String, String>>();
		CodeService service = (CodeService) ApplicationHelper.getService("codeService", context);
		CodeCommand cmd = new CodeCommand();
		cmd.setList(service.getCodes(cmd));

		for (int i = 0; i < cmd.getList().size(); i++) {
			CodeCommand _cmd = new CodeCommand();
			_cmd = (CodeCommand) cmd.getList().get(i);

			LOGGER.debug("			:: System Code Data : [Main Key] " + _cmd.getCd_id());

			LinkedHashMap<String, String> map = new LinkedHashMap<String, String>();
			for (int j = 0; j < _cmd.getList().size(); j++) {
				CodeCommand __cmd = new CodeCommand();
				__cmd = (CodeCommand) _cmd.getList().get(j);
				map.put(__cmd.getCd_id(), __cmd.getCd_nm());

				LOGGER.debug("			:: System Code Data : 		[Sub Key] " + __cmd.getCd_id() + "		[Value] " + __cmd.getCd_nm());
			}

			codes.put(_cmd.getCd_id(), map);
		}

		/**
		 * Y or N 은 DB에 등록하지 않아도 사용가능 하도록 한다.
		 */
		LinkedHashMap<String, String> map = new LinkedHashMap<String, String>();
		map.put("Y", "Y");
		map.put("N", "N");
		codes.put("yn", map);

		context.setAttribute(Constants.CODES, codes);
	}

	@SuppressWarnings("unchecked")
	public static LinkedHashMap<String, String> get(ServletContext context, String key) {
		Map<String, LinkedHashMap<String, String>> codes = new HashMap<String, LinkedHashMap<String, String>>();
		codes = (Map<String, LinkedHashMap<String, String>>) context.getAttribute(Constants.CODES);
		return codes.get(key);
	}

	@SuppressWarnings("unchecked")
	public static LinkedHashMap<String, String> get(String key) {
		Map<String, LinkedHashMap<String, String>> codes = new HashMap<String, LinkedHashMap<String, String>>();
		HttpServletRequest req = ((ServletRequestAttributes) RequestContextHolder.getRequestAttributes()).getRequest();
		codes = (Map<String, LinkedHashMap<String, String>>) req.getSession().getServletContext().getAttribute(Constants.CODES);
		return codes.get(key);
	}

	public static String get(ServletContext context, String key, String subkey) {
		return ((LinkedHashMap<String, String>) get(context, key)).get(subkey);
	}

	public static String get(String key, String subkey) {
		return ((LinkedHashMap<String, String>) get(key)).get(subkey);
	}
}
