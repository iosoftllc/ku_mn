package iosf.com.program.attach.web;

import java.util.Map;

import org.apache.commons.lang3.StringUtils;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.servlet.ModelAndView;

import iosf.com.generic.web.GenericController;
import iosf.com.program.attach.service.AttachService;
import iosf.com.support.util.Functions;
import iosf.com.sys.Constants;

@Controller
@RequestMapping(value = { "/back/attach", "/front/attach" })
public class AttachController extends GenericController<AttachService, AttachCommand> {
	/**
	 * 첨부파일 모듈 화면
	 * 
	 * 항상 include 된 상태로 호출이 된다.
	 * 
	 * @param cmd
	 * @param vars
	 * @return
	 * @throws Exception
	 */
	@GetMapping(value = { "/embed", "/embed/write" })
	public ModelAndView embed(AttachCommand cmd, @PathVariable Map<String, String> vars) throws Exception {
		// TODO Auto-generated method stub
		cmd.setPage_use_yn("N");
		cmd.setPage_count_use_yn("N");

		// 항상 include 상태에서 호출되므로 getServletPath() 를 사용하지 않는다.
		String path = (String) Functions.getReq().getAttribute("javax.servlet.include.servlet_path");
		setView(path.contains("/write") ? "" : "/view");

		ModelAndView mav = new ModelAndView();
		mav.addObject(Constants.CMD_VALUE, StringUtils.isEmpty(cmd.getAttach_idx()) ? null : getService().getList(cmd));
		return mav(mav, cmd, vars);
	}

	/**
	 * 파일다운로드
	 * 
	 * attach_idx 와 attach_seq를 모두 매칭한다 (보안점검 지적사항)
	 * 
	 * @param cmd
	 * @param req
	 * @param res
	 * @throws Exception
	 */
	@GetMapping(value = { "/download/{attach_idx}", "/download/{attach_idx}/{attach_seq}" })
	public void download(AttachCommand cmd, @PathVariable Map<String, String> vars) throws Exception {
		cmd.setAttach_idx("" + vars.get("attach_idx"));
		if (vars.get("attach_seq") != null) {
			cmd.setAttach_seq(Long.parseLong("" + vars.get("attach_seq")));
		}

		getService().download(cmd);
	}

	/**
	 * 이미지 보기
	 * 
	 * size는 썸네일 선택사항
	 * attach_seq는 선택사항 맨 뒤에 위치한다.
	 * 
	 * @param cmd
	 * @param vars
	 * @throws Exception
	 */
	@GetMapping(value = { "/preview/{attach_idx}", "/preview/{attach_idx}/{size}", "/preview/{attach_idx}/{size}/{attach_seq}" })
	public void preview(AttachCommand cmd, @PathVariable Map<String, String> vars) throws Exception {
		// TODO Auto-generated method stub
		cmd.setAttach_idx("" + vars.get("attach_idx"));
		if (vars.get("attach_seq") != null) {
			cmd.setAttach_seq(Long.parseLong("" + vars.get("attach_seq")));
		}
		cmd.setThumb_size("" + vars.get("size"));

		getService().preview(cmd);
	}
}
