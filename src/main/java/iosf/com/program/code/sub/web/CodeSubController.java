package iosf.com.program.code.sub.web;

import java.util.Map;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.servlet.ModelAndView;

import iosf.com.generic.web.GenericController;
import iosf.com.program.code.service.CodeService;
import iosf.com.program.code.web.CodeCommand;
import iosf.com.support.util.Functions;
import iosf.com.sys.Codes;
import iosf.com.sys.Constants;

@Controller
@RequestMapping("/back/code/{up_cd_seq}/sub")
public class CodeSubController extends GenericController<CodeService, CodeCommand> {
	@Override
	protected void postControl(CodeCommand cmd, ModelAndView mav, @PathVariable Map<String, String> vars) throws Exception {
		// TODO Auto-generated method stub

		// 조회 화면에서만 상위 코드 정보를 가져온다
		if (Functions.getReq().getMethod().equalsIgnoreCase("get")) {
			cmd.setSeq(Long.parseLong("" + vars.get("up_cd_seq"), 10));
			mav.addObject(Constants.MASTER_CMD_VALUE, getService().getView(cmd));
		} else {
			new Codes(Functions.getReq().getServletContext());
		}

		super.postControl(cmd, mav, vars);
	}

	@Override
	public ModelAndView list(CodeCommand cmd, @PathVariable Map<String, String> vars) throws Exception {
		// TODO Auto-generated method stub
		cmd.setPage_use_yn("N");
		cmd.setSearch_field(null);
		cmd.setSearch_keyword(null);
		return super.list(cmd, vars);
	}
}
