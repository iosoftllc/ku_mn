package iosf.com.sys;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.springframework.web.servlet.ModelAndView;
import org.springframework.web.servlet.ModelAndViewDefiningException;
import org.springframework.web.servlet.handler.HandlerInterceptorAdapter;

import iosf.com.support.util.Functions;

public class IosfInterceptor extends HandlerInterceptorAdapter {

	@Override
	public boolean preHandle(HttpServletRequest request, HttpServletResponse response, Object handler) throws Exception {
		// TODO Auto-generated method stub
		String uri = request.getRequestURI();

		// 로그인이 필요한 프로그램
		if (uri.contains("/ask")) {
			if (Functions.getUser() == null) {
				ModelAndView modelAndView = new ModelAndView("redirect:/front/user/login");
				throw new ModelAndViewDefiningException(modelAndView);
			}
		}

		return super.preHandle(request, response, handler);
	}

	@Override
	public void postHandle(HttpServletRequest request, HttpServletResponse response, Object handler, ModelAndView modelAndView) throws Exception {
		// TODO Auto-generated method stub

		super.postHandle(request, response, handler, modelAndView);
	}

	@Override
	public void afterCompletion(HttpServletRequest request, HttpServletResponse response, Object handler, Exception ex) throws Exception {
		// TODO Auto-generated method stub

		super.afterCompletion(request, response, handler, ex);
	}
}
