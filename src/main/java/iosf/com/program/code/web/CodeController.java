package iosf.com.program.code.web;

import org.apache.commons.lang.StringUtils;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.servlet.ModelAndView;

import iosf.com.generic.web.GenericController;
import iosf.com.program.code.service.CodeService;

@Controller
@RequestMapping("/back/code")
public class CodeController extends GenericController<CodeService, CodeCommand> {
	@GetMapping("/check")
	public ModelAndView check(CodeCommand cmd) throws Exception {
		return callback(StringUtils.isEmpty(getService().getCheck(cmd)));
	}
}
