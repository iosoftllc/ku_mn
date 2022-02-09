package iosf.com.layout.web;

import javax.annotation.Resource;

import org.springframework.stereotype.Controller;
import org.springframework.web.servlet.ModelAndView;

import iosf.com.generic.web.GenericMainController;
import iosf.com.layout.service.MainService;
import iosf.com.program.extend.notice.service.NoticeService;
import iosf.com.program.extend.notice.web.NoticeCommand;
import iosf.com.support.util.ApplicationHelper;
import iosf.com.support.util.Functions;

@Controller
public class MainController extends GenericMainController {

	@Resource(name = "mainService")
	private MainService mainService;

	@Override
	public ModelAndView front_main() throws Exception {
		ModelAndView mav = super.front_main();

		NoticeCommand noticeCmd = new NoticeCommand();
		NoticeService noticeService = (NoticeService) ApplicationHelper.getService("noticeService", Functions.getReq().getServletContext());
		noticeCmd.setPage_use_yn("Y");
		noticeCmd.setPage_count_use_yn("Y");
		noticeCmd.setRecord_count_per_page(10);
		noticeCmd = noticeService.getList(noticeCmd);

		mav.addObject("notice", noticeCmd);
		return mav;
	}

}
