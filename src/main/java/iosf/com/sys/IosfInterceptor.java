package iosf.com.sys;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.commons.lang3.StringUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.util.StopWatch;
import org.springframework.web.servlet.ModelAndView;
import org.springframework.web.servlet.handler.HandlerInterceptorAdapter;

import egovframework.com.cmm.util.EgovUserDetailsHelper;
import iosf.com.support.util.Functions;

public class IosfInterceptor extends HandlerInterceptorAdapter {

	private static final Logger LOGGER = LoggerFactory.getLogger(IosfInterceptor.class);
	private StopWatch stopWatch = new StopWatch();
	private StopWatch stopWatch_include = new StopWatch();

	@Override
	public boolean preHandle(HttpServletRequest request, HttpServletResponse response, Object handler) throws Exception {
		// TODO Auto-generated method stub
		String include_servlet_path = (String) Functions.getReq().getAttribute("javax.servlet.include.servlet_path");
		if (include_servlet_path == null) {
			if (!stopWatch.isRunning()) {
				stopWatch.start();
				LOGGER.debug("		:: 공통 포함 로직 실행 - {}", request.getRequestURI());
			}
		} else {
			if (!stopWatch_include.isRunning()) {
				stopWatch_include.start();
				LOGGER.debug("		:: 공통 포함 로직 실행 (included) - {}", include_servlet_path);
			}
		}

		return super.preHandle(request, response, handler);
	}

	@Override
	public void postHandle(HttpServletRequest request, HttpServletResponse response, Object handler, ModelAndView modelAndView) throws Exception {
		// TODO Auto-generated method stub
		String uri = request.getRequestURI();

		// 고려대학교 로그인 연계 정보 동의서
		if (uri.contains("/front") && uri.contains("/write") && !EgovUserDetailsHelper.getAuthorities().contains("ROLE_ADMIN")) {
			if ("N".equals(StringUtils.defaultIfEmpty(Functions.getUser().getAgree_yn(), "N"))) {
				modelAndView.setViewName("/front/common/agree");
				return;
			}
		}
		super.postHandle(request, response, handler, modelAndView);
	}

	@Override
	public void afterCompletion(HttpServletRequest request, HttpServletResponse response, Object handler, Exception ex) throws Exception {
		// TODO Auto-generated method stub

		super.afterCompletion(request, response, handler, ex);
	}
}
