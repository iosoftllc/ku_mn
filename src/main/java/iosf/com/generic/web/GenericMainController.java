package iosf.com.generic.web;

import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.servlet.ModelAndView;

import egovframework.com.cmm.util.EgovUserDetailsHelper;
import iosf.com.program.user.web.UserCommand;

/**
 * Generic Main Page Controller
 * 
 * @author Park sung hyun
 * 
 */
public class GenericMainController {
	@RequestMapping("/front/main")
	public ModelAndView front_main() throws Exception {
		ModelAndView mav = new ModelAndView();
		//mav.setViewName("layout.front.main");
		mav.setViewName("layout.front.main");
		return mav;
	}

	@RequestMapping("/back/main")
	public ModelAndView back_main() throws Exception {
		ModelAndView mav = new ModelAndView();
		mav.setViewName("layout.back.main");
		return mav;
	}

	/**
	 * 사용자 정보 얻기
	 * 
	 * @return
	 */
	public UserCommand getUser() {
		UserCommand cmd = (UserCommand) EgovUserDetailsHelper.getAuthenticatedUser();
		if (cmd != null) {
			return cmd;
		}
		return null;
	}
}
