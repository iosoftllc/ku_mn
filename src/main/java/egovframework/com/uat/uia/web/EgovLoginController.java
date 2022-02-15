package egovframework.com.uat.uia.web;

import java.util.HashMap;
import java.util.Map;

import javax.annotation.Resource;
import javax.servlet.http.HttpServletRequest;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.stereotype.Controller;
import org.springframework.ui.ModelMap;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;

import egovframework.com.cmm.EgovComponentChecker;
import egovframework.com.cmm.EgovMessageSource;
import egovframework.com.cmm.LoginVO;
import iosf.com.program.user.web.UserCommand;
import iosf.com.support.util.DecodeEncryptor168;
import iosf.com.support.util.DecodeEncryptorLocal168;
import iosf.com.sys.Constants;

/*
 import com.gpki.gpkiapi.cert.X509Certificate;
 import com.gpki.servlet.GPKIHttpServletRequest;
 import com.gpki.servlet.GPKIHttpServletResponse;
 */

/**
 * 일반 로그인, 인증서 로그인을 처리하는 컨트롤러 클래스
 * 
 * @author 공통서비스 개발팀 박지욱
 * @since 2009.03.06
 * @version 1.0
 * @see
 *
 *      <pre>
 * << 개정이력(Modification Information) >>
 * 
 *   수정일      수정자          수정내용
 *  -------    --------    ---------------------------
 *  2009.03.06  박지욱          최초 생성
 *  2011.8.26	정진오			IncludedInfo annotation 추가
 *  2011.09.07  서준식          스프링 시큐리티 로그인 및 SSO 인증 로직을 필터로 분리
 *  2011.09.25  서준식          사용자 관리 컴포넌트 미포함에 대한 점검 로직 추가
 *  2011.09.27  서준식          인증서 로그인시 스프링 시큐리티 사용에 대한 체크 로직 추가
 *  2011.10.27  서준식          아이디 찾기 기능에서 사용자 리름 공백 제거 기능 추가
 *      </pre>
 */
@Controller
public class EgovLoginController {

	/** EgovMessageSource */
	@Resource(name = "egovMessageSource")
	EgovMessageSource egovMessageSource;

	/** log */
	private static final Logger LOGGER = LoggerFactory.getLogger(EgovLoginController.class);
	private static final String FAIL_URL = "redirect:/front/user/login?fail=Y";
	private static final String SUCCESS_URL = "redirect:/front/main";

	/**
	 * 로그인 화면으로 들어간다
	 * 
	 * @param vo
	 *            - 로그인후 이동할 URL이 담긴 LoginVO
	 * @return 로그인 페이지
	 * @exception Exception
	 */
	@RequestMapping(value = "/front/user/login", method = RequestMethod.GET)
	public String backLloginUsrView(@ModelAttribute("loginVO") LoginVO loginVO, ModelMap model) throws Exception {
		if (EgovComponentChecker.hasComponent("mberManageService")) {
			model.addAttribute("useMemberManage", "true");
		}
		LOGGER.debug("		:: Call Login Page");
		return "/user/login";
	}

	/**
	 * SSO 로그인
	 * 
	 * @param loginVO
	 * @param request
	 * @param model
	 * @return
	 * @throws Exception
	 */
	@PostMapping("/user/login")
	public String actionLoginSSO(@ModelAttribute("loginVO") LoginVO loginVO, HttpServletRequest request, ModelMap model) throws Exception {

		String decrypted = "";
		String sYn = request.getParameter("sYN");
		if (sYn.equals("Y")) {
			if (request.getServerName().contains("local")) {
				String encrypted = request.getParameter("msg");
				String randomKey = DecodeEncryptorLocal168.decodeRandomKey(DecodeEncryptorLocal168.findRandomKey(encrypted));

				String key2 = "local.korea.ac.kr163.152.7.214" + randomKey; // xxx.korea.ac.kr-->홈페이지url
				String originData = DecodeEncryptorLocal168.findOriginData(encrypted);
				decrypted = DecodeEncryptorLocal168.decrypt(key2.getBytes(), DecodeEncryptorLocal168.decode(originData));
			} else {
				String encrypted = request.getParameter("msg");
				String randomKey = DecodeEncryptor168.decodeRandomKey(DecodeEncryptor168.findRandomKey(encrypted));

				String key2 = "card.korea.ac.kr163.152.5.28" + randomKey; // xxx.korea.ac.kr-->홈페이지url
				String originData = DecodeEncryptor168.findOriginData(encrypted);
				decrypted = DecodeEncryptor168.decrypt(key2.getBytes(), DecodeEncryptor168.decode(originData));
			}
		} else {
			return FAIL_URL + "&msg=" + request.getParameter("sWHY");
		}

		UserCommand userLoginCmd = new UserCommand();

		LOGGER.debug("		:: SSO Return msg enc : " + request.getParameter("msg"));
		LOGGER.debug("		:: SSO Return msg dec : " + decrypted);

		//{sEmpNos=eswing:, sDeptCd=AA08002, campus=0:, sGnm=공용, sNAME=STM, sUID=eswing, sDeptNm=전산개발부, sStdId=eswing, sGids=EC:, sDeptCds=AA08002:, sDeptNms=전산개발부:, serverIP=163.152.7.214, serverDomain=local.korea.ac.kr, sGid=EC}
		Map<String, String> map = new HashMap<String, String>();
		for (String p : decrypted.split("&")) {
			map.put(p.split("=")[0], p.split("=")[1]);
		}
		userLoginCmd.setUser_id(map.get("sUID")); // 포털 아이디
		userLoginCmd.setStd_id(map.get("sStdId")); // 교번
		userLoginCmd.setUser_nm(map.get("sNAME"));
		userLoginCmd.setDept_nm(map.get("sDeptNm"));
		userLoginCmd.setStd_ids(map.get("sEmpNos"));

		if (userLoginCmd == null) {
			return FAIL_URL;
		}

		LoginVO resultVO = new LoginVO();
		resultVO.setId(userLoginCmd.getUser_id());
		resultVO.setInfo(userLoginCmd);
		resultVO.setIp(request.getRemoteAddr());
		resultVO.setUniqId(resultVO.getId());

		request.getSession().setAttribute(Constants.SESSION_EGOVUSER, resultVO);

		return SUCCESS_URL;
	}

	/**
	 * 로그아웃한다.
	 * 
	 * @return String
	 * @exception Exception
	 */
	@GetMapping(value = "/user/logout")
	public String actionLogout(HttpServletRequest request, ModelMap model) throws Exception {

		request.getSession().setAttribute(Constants.SESSION_EGOVUSER, null);

		return "redirect:/";

	}
}