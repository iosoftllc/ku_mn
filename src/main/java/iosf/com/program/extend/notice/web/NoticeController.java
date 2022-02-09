package iosf.com.program.extend.notice.web;

import java.util.Map;

import org.apache.commons.lang.StringUtils;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.servlet.ModelAndView;

import iosf.com.generic.web.GenericController;
import iosf.com.program.extend.notice.service.NoticeService;
import iosf.com.support.util.Functions;
import iosf.com.sys.Constants;

@Controller
@RequestMapping("/front/notice")
public class NoticeController extends GenericController<NoticeService, NoticeCommand> {

	@Override
	public ModelAndView view(NoticeCommand cmd, @PathVariable Map<String, String> vars) throws Exception {
		ModelAndView mav = super.view(cmd, vars);

		String token = (String) Functions.getReq().getSession().getAttribute(Constants.TOKEN_REQ);
		if (StringUtils.isEmpty(token) || (token != null && !token.equals(vars.get("seq")))) {
			Functions.getReq().getSession().setAttribute(Constants.TOKEN_REQ, vars.get("seq"));
			getService().updateHit(cmd);
		}

		return super.mav(mav, cmd, vars);
	}
}
