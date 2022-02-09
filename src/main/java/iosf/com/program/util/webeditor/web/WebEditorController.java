package iosf.com.program.util.webeditor.web;

import java.util.List;
import java.util.Map;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.multipart.MultipartFile;
import org.springframework.web.multipart.MultipartHttpServletRequest;
import org.springframework.web.servlet.ModelAndView;

import iosf.com.program.attach.util.AttachUtil;
import iosf.com.sys.Constants;

@Controller
@RequestMapping("/util/webeditor")
public class WebEditorController {
	@Autowired
	private AttachUtil attachUtil;

	@PostMapping("/uploadimage")
	public ModelAndView uploadimage(WebEditorCommand cmd, final MultipartHttpServletRequest multireq, BindingResult bindingResult, ModelAndView mav) throws Exception {
		final Map<String, List<MultipartFile>> files = multireq.getMultiFileMap();
		if (!files.isEmpty()) {
			cmd.setAttach_idx(attachUtil.upload(files.get("files")));
		}
		return callback(cmd, mav);
	}

	@PostMapping("/uploadfile")
	public ModelAndView uploadfile(WebEditorCommand cmd, final MultipartHttpServletRequest multireq, BindingResult bindingResult, ModelAndView mav) throws Exception {
		final Map<String, List<MultipartFile>> files = multireq.getMultiFileMap();
		if (!files.isEmpty()) {
			cmd.setAttach_idx(attachUtil.upload(files.get("files")));
		}
		return callback(cmd, mav);
	}

	@PostMapping("/uploadpdf")
	public ModelAndView uploadpdf(WebEditorCommand cmd, final MultipartHttpServletRequest multireq, BindingResult bindingResult, ModelAndView mav) throws Exception {
		final Map<String, List<MultipartFile>> files = multireq.getMultiFileMap();
		if (!files.isEmpty()) {
			cmd.setAttach_idx(attachUtil.upload(files.get("files")));
		}
		return callback(cmd, mav);
	}

	@PostMapping("/imagemap")
	public ModelAndView imagemap(WebEditorCommand cmd, final MultipartHttpServletRequest multireq, BindingResult bindingResult, ModelAndView mav) throws Exception {
		final Map<String, List<MultipartFile>> files = multireq.getMultiFileMap();
		if (!files.isEmpty()) {
			cmd.setAttach_idx(attachUtil.upload(files.get("files")));
		}
		return callback(cmd, mav);
	}

	@GetMapping("/imagemap")
	public ModelAndView imagemap_tool(WebEditorCommand cmd, ModelAndView mav) throws Exception {
		mav.setViewName("util.webeditor.imagemap");
		return mav;
	}

	private ModelAndView callback(WebEditorCommand cmd, ModelAndView mav) throws Exception {
		mav.setViewName("util.webeditor.callback");
		mav.addObject(Constants.CMD_VALUE, cmd);
		return mav;
	}
}
