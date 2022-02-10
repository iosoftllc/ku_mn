package iosf.com.generic.web;

import java.io.FileNotFoundException;
import java.io.IOException;
import java.net.URL;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.Map.Entry;

import javax.annotation.PostConstruct;
import javax.annotation.Resource;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;

import org.apache.commons.lang.StringUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Qualifier;
import org.springframework.context.ApplicationContext;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.DeleteMapping;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PatchMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.context.request.RequestContextHolder;
import org.springframework.web.context.request.ServletRequestAttributes;
import org.springframework.web.multipart.MultipartFile;
import org.springframework.web.multipart.MultipartHttpServletRequest;
import org.springframework.web.servlet.ModelAndView;
import org.springmodules.validation.commons.DefaultBeanValidator;

import egovframework.com.cmm.LoginVO;
import egovframework.com.cmm.util.EgovDoubleSubmitHelper;
import egovframework.com.cmm.util.EgovUserDetailsHelper;
import egovframework.rte.fdl.property.EgovPropertyService;
import egovframework.rte.ptl.mvc.tags.ui.pagination.PaginationInfo;
import iosf.com.generic.service.GenericService;
import iosf.com.program.attach.util.AttachUtil;
import iosf.com.program.user.web.UserCommand;
import iosf.com.support.util.ApplicationHelper;
import iosf.com.support.util.Functions;
import iosf.com.sys.Constants;
import lombok.Getter;
import lombok.Setter;

/**
 * Generic Controller
 * 
 * @author Park sung hyun
 * 
 * @param <S>
 * @param <C>
 */
@Setter
@Getter
public class GenericController<S extends GenericService<C>, C extends GenericCommand> {

	@Autowired
	private ApplicationContext applicationContext;
	@Qualifier
	private S service;
	@Resource(name = "propertiesService")
	private EgovPropertyService propertyService;
	@Resource(name = "attachUtil")
	private AttachUtil attachUtil;
	@Autowired
	private DefaultBeanValidator beanValidator;

	private Class<S> serviceClass;
	private String view; // Tiles의 ID와 매핑하기 위한 변수
	private String thumb_yn, thumb_main_yn, thumb_sub1_yn, thumb_sub2_yn, thumb_sub3_yn, thumb_sub4_yn, thumb_sub5_yn; // 첨부시 썸네일 생성 여부
	private String thumb_size, thumb_main_size, thumb_sub1_size, thumb_sub2_size, thumb_sub3_size, thumb_sub4_size, thumb_sub5_size; // 첨부시 썸네일 사이즈
	protected final Logger LOGGER = LoggerFactory.getLogger(GenericController.class);

	/**
	 * 초기화
	 */
	@SuppressWarnings("unchecked")
	public GenericController() {
		this.serviceClass = (Class<S>) GenericUtils.getClassOfGenericTypeIn(getClass(), 0);
		this.view = "";
		this.thumb_yn = "N";
		this.thumb_main_yn = "N";
		this.thumb_sub1_yn = "N";
		this.thumb_sub2_yn = "N";
		this.thumb_sub3_yn = "N";
		this.thumb_sub4_yn = "N";
		this.thumb_sub5_yn = "N";
		this.thumb_size = "100"; // ;로 구분한다 (ex: 80;100)
		this.thumb_main_size = "100"; // ;로 구분한다 (ex: 80;100)
		this.thumb_sub1_size = "100"; // ;로 구분한다 (ex: 80;100)
		this.thumb_sub2_size = "100"; // ;로 구분한다 (ex: 80;100)
		this.thumb_sub3_size = "100"; // ;로 구분한다 (ex: 80;100)
		this.thumb_sub4_size = "100"; // ;로 구분한다 (ex: 80;100)
		this.thumb_sub5_size = "100"; // ;로 구분한다 (ex: 80;100)
	}

	/**
	 * Spring 에 정의된 Bean들이 로드 된 후 호출 된다.
	 */
	@PostConstruct
	public void setUp() {
		this.service = applicationContext.getBean(serviceClass);
	}

	/**
	 * 로그 찍기
	 * 
	 * @param cmd
	 */
	protected void logging(C cmd, Map<String, String> vars) {
		LOGGER.debug("		:: 제네릭 컨트롤러 호출 정보");
		LOGGER.debug("		:: Controller : {}", getClass().getName());
		LOGGER.debug("		:: ServiceClass : {}", service.toString());
		LOGGER.debug("		:: CommandClass : {}", cmd.getClass().getName());
		LOGGER.debug("		:: QueryString : {}", Functions.getQueryString());

		LOGGER.debug("		:: Base Url : {}", Functions.getReq().getServletPath());
		LOGGER.debug("		:: View : {}", this.view);

		String logPathVars = "";
		if (vars != null) {
			try {
				for (Entry<String, String> el : ((Map<String, String>) vars).entrySet()) {
					logPathVars += ("".equals(logPathVars) ? "" : ", ") + el.getKey() + "=" + el.getValue();
				}
			} catch (ClassCastException e) {
				// TODO: handle exception
				LOGGER.error("		:: 정상적으로 코딩한 경우 @override한 함수의 vars 인자값 앞에 @Variables를 추가해야 합니다.");
			}
		}

		LOGGER.debug("		:: Path Variables : {}", logPathVars);

		LOGGER.debug("		:: Thumbnail : {} ({})", this.thumb_yn, this.thumb_size);
		LOGGER.debug("		:: Thumbnail for Main : {} ({})", this.thumb_main_yn, this.thumb_main_size);
		LOGGER.debug("		:: Thumbnail Sub1 : {} ({})", this.thumb_sub1_yn, this.thumb_sub1_size);
		LOGGER.debug("		:: Thumbnail Sub2 : {} ({})", this.thumb_sub2_yn, this.thumb_sub2_size);
		LOGGER.debug("		:: Thumbnail Sub3 : {} ({})", this.thumb_sub3_yn, this.thumb_sub3_size);
		LOGGER.debug("		:: Thumbnail Sub4 : {} ({})", this.thumb_sub4_yn, this.thumb_sub4_size);
		LOGGER.debug("		:: Thumbnail Sub5 : {} ({})", this.thumb_sub5_yn, this.thumb_sub5_size);

		LOGGER.debug("		:: Paging : {}", cmd.getPage_use_yn());
		LOGGER.debug("		:: Paging Count : {}", cmd.getPage_count_use_yn());
		LOGGER.debug("		:: Test : {}", cmd.getTest_yn());
	}

	/**
	 * Generic 함수 처리 전 필터역할 함수 (pre 함수보다 먼저 수행)
	 * 
	 * @param cmd
	 * @param req
	 * @param res
	 * @throws Exception
	 */
	protected void wrapper(C cmd, Map<String, String> vars) throws Exception {
		logging(cmd, vars);
	}

	/**
	 * 사용자 정보 얻기
	 * 
	 * @return
	 */
	public UserCommand getUser() {
		Object obj = EgovUserDetailsHelper.getAuthenticatedUser();
		if (obj != null) {
			if (Functions.getReq().getSession().getAttribute(Constants.SESSION_USERINFO) == null) {
				return ((LoginVO) obj).getInfo();
			}
			return (UserCommand) Functions.getReq().getSession().getAttribute(Constants.SESSION_USERINFO);
		}

		return null;
	}

	/**
	 * 비어있는 ModelAndView 호출 함수
	 * 
	 * @return
	 * @throws Exception
	 */
	@SuppressWarnings("unchecked")
	protected ModelAndView mav() throws Exception {
		ModelAndView mav = new ModelAndView();
		GenericCommand cmd = new GenericCommand();
		return mav(mav, (C) cmd, null);
	}

	/**
	 * ModelAndView 처리
	 * 
	 * @param cmd
	 * @return
	 * @throws Exception
	 */
	protected ModelAndView mav(C cmd) throws Exception {
		ModelAndView mav = new ModelAndView();
		return mav(mav, cmd, null);
	}

	/**
	 * ModelAndView 호출 함수 (ModelAndView 전용)
	 * 
	 * @param mav
	 * @param cmd
	 * @return
	 * @throws Exception
	 */
	protected ModelAndView mav(ModelAndView mav, C cmd, Map<String, String> vars) throws Exception {
		// include 된 경우 아래 경로로 servlet path를 받아온다.
		String include_servlet_path = (String) Functions.getReq().getAttribute("javax.servlet.include.servlet_path");
		if (include_servlet_path == null) {
			include_servlet_path = Functions.getReq().getServletPath();
		}
		if (vars != null) {
			// 정확한 replace 를 위해서 끝에 / 추가한다.
			include_servlet_path = include_servlet_path + "/";
			for (Entry<String, String> el : ((Map<String, String>) vars).entrySet()) {
				LOGGER.debug("		:: Call Tiles replace value : /" + el.getValue() + "/");
				include_servlet_path = include_servlet_path.replaceFirst("/" + el.getValue() + "/", "/");
			}
			// 마지막에 추가한 / 를 제거한 값을 보낸다
			include_servlet_path = include_servlet_path.substring(0, include_servlet_path.length() - 1);
		}
		return mav(mav, include_servlet_path);
	}

	protected ModelAndView mav(ModelAndView mav, String path) throws Exception {
		String vm = path + this.view;
		LOGGER.debug("		:: Call Tiles View : " + vm);

		mav.setViewName(vm);
		return mav;
	}

	/**
	 * callback.jsp 호출 (ModelAndView 전용)
	 * 
	 * @param callbackValue
	 * @return
	 * @throws Exception
	 */
	protected ModelAndView callback(Object callbackValue) throws Exception {
		LOGGER.debug("		:: Call Callback Tiles View : " + Constants.CALLBACK_VIEW);

		ModelAndView mav = new ModelAndView();
		mav.addObject(Constants.CALLBACK_VALUE, callbackValue);
		mav.setViewName(Constants.CALLBACK_VIEW);
		return mav;
	}

	/**
	 * callback.jsp 호출 (redirect 전용)
	 * 
	 * @param callbackValue
	 * @return
	 * @throws Exception
	 */
	protected String redirectCallback(String callbackValue) throws Exception {
		return redirectCallback("", callbackValue);
	}

	protected String redirectCallback(String path, String callbackValue) throws Exception {
		String url = "redirect:" + Functions.getReq().getServletPath() + path + "/callback?" + Constants.CALLBACK_VALUE + "=" + callbackValue + "&" + Functions.getQueryString();
		LOGGER.debug("		:: Call Callback URL : " + url);
		return url;
	}

	/**
	 * Generic 함수 전처리
	 * 
	 * @param cmd
	 * @param mav
	 * @throws Exception
	 */
	protected void preControl(C cmd, ModelAndView mav, Map<String, String> vars) throws Exception {
		LOGGER.debug("		:: Call Pre Control ");
	}

	/**
	 * Generic 함수 후처리
	 * 
	 * @param cmd
	 * @param mav
	 * @throws Exception
	 */
	protected void postControl(C cmd, ModelAndView mav, Map<String, String> vars) throws Exception {
		LOGGER.debug("		:: Call Post Control ");
	}

	/**
	 * 중복 Submit 셋팅
	 * 
	 * @return
	 */
	protected boolean setProtectSubmit() {
		return setProtectSubmit(EgovDoubleSubmitHelper.DEFAULT_TOKEN_KEY);
	}

	/**
	 * 중복 Submit 셋팅
	 * 
	 * @param token_key
	 * @return
	 */
	@SuppressWarnings("unchecked")
	protected boolean setProtectSubmit(String token_key) {
		/**
		 * 전자정부 jsp 에 set하는 내용을 자동화
		 * https://www.egovframe.go.kr/wiki/doku.php?id=egovframework:com:v3:cmm:doublesubmit
		 * 
		 * IOSF 에서는 insert/update 화면 로직에 정의한다.
		 */
		HttpServletRequest request = ((ServletRequestAttributes) RequestContextHolder.getRequestAttributes()).getRequest();
		HttpSession session = request.getSession();
		Map<String, String> map = null;

		if (session.getAttribute(EgovDoubleSubmitHelper.SESSION_TOKEN_KEY) == null) {
			map = new HashMap<String, String>();
		} else {
			map = (HashMap<String, String>) session.getAttribute(EgovDoubleSubmitHelper.SESSION_TOKEN_KEY);
		}

		// First call (check session)
		if (StringUtils.isNotEmpty(token_key) && map.get(token_key) == null) {
			map.put(token_key, EgovDoubleSubmitHelper.getNewUUID());
			LOGGER.debug("[Double Submit] session token created({}) : {}", token_key, map.get(token_key));
		}

		session.setAttribute(EgovDoubleSubmitHelper.SESSION_TOKEN_KEY, map);
		session.setAttribute(token_key, map.get(token_key));
		return true;
	}

	/**
	 * 중복 Submit 처리
	 * 
	 * @param req
	 * @param key
	 * @return
	 */
	protected boolean isProtectSubmit() {
		return isProtectSubmit(EgovDoubleSubmitHelper.DEFAULT_TOKEN_KEY);
	}

	/**
	 * 중복 Submit 처리
	 * 
	 * @param token_key
	 * @return
	 */
	protected boolean isProtectSubmit(String token_key) {
		return EgovDoubleSubmitHelper.checkAndSaveToken(token_key);
	}

	/**
	 * 모든 파라메터를 포함한 redirect
	 * 
	 * @return
	 * @throws Exception
	 */
	protected String redirect() throws Exception {
		return redirect(null, null);
	}

	/**
	 * 모든 파라메터를 포함한 특정 URL로 redirect
	 * 
	 * @param url
	 * @return
	 * @throws Exception
	 */
	protected String redirect(String url) throws Exception {
		return redirect(url, null);
	}

	/**
	 * 특정 파라메터를 제외하고 특정 URL로 redirect
	 * 
	 * @param queryStringException
	 * @return
	 * @throws Exception
	 */
	protected String redirect(String url, String queryStringException) throws Exception {
		if (url == null) {
			url = Functions.getReq().getServletPath();
		}
		String redirect = "redirect:" + url + "?" + Functions.getQueryString(queryStringException);
		LOGGER.debug("		:: " + redirect);
		return redirect;
	}

	/**
	 * 리스트 화면 (Get)
	 * 
	 * @param cmd
	 * @return
	 * @throws Exception
	 * 
	 *             URL 패턴
	 *             /back/code -> LIST 화면
	 *             /back/code/1 -> VIEW 화면
	 *             /back/code/write -> INSERT 화면
	 *             /back/code/write/1 -> UPDATE 화면
	 *             주의사항
	 *             /write 는 여러번 사용 금지
	 *             ex) /back/code/write/1/sub/write (X)
	 *             ex) /back/code/1/sub/write (O)
	 * 
	 */
	@GetMapping()
	public ModelAndView list(@ModelAttribute(Constants.CMD_VALUE) C cmd, @PathVariable Map<String, String> vars) throws Exception {
		ModelAndView mav = new ModelAndView();
		this.view = "/list";

		preControl(cmd, mav, vars);
		wrapper(cmd, vars);

		cmd.setPage_use_yn(StringUtils.defaultIfEmpty(cmd.getPage_use_yn(), "Y"));
		cmd.setPage_count_use_yn(StringUtils.defaultIfEmpty(cmd.getPage_count_use_yn(), "Y"));

		/** pageing setting */
		if (cmd.getCurrent_page_no() <= 0) {
			cmd.setCurrent_page_no(1);
		}
		if (cmd.getRecord_count_per_page() <= 0) {
			cmd.setRecord_count_per_page(this.propertyService.getInt("pageUnit"));
		}
		if (cmd.getPage_size() <= 0) {
			cmd.setPage_size(this.propertyService.getInt("pageSize"));
		}

		PaginationInfo paginationInfo = new PaginationInfo();
		paginationInfo.setCurrentPageNo(cmd.getCurrent_page_no());
		paginationInfo.setRecordCountPerPage(cmd.getRecord_count_per_page());
		paginationInfo.setPageSize(cmd.getPage_size());

		cmd.setFirst_index(paginationInfo.getFirstRecordIndex());
		cmd.setLast_index(paginationInfo.getLastRecordIndex());
		cmd.setRecord_count_per_page(paginationInfo.getRecordCountPerPage());

		mav.addObject(Constants.CMD_VALUE, ((StringUtils.isEmpty(cmd.getLoad_yn()) || !"N".equals(cmd.getLoad_yn())) ? service.getList(cmd) : cmd));

		paginationInfo.setTotalRecordCount(cmd.getTotal_record_count());
		mav.addObject("paginationInfo", paginationInfo);

		postControl(cmd, mav, vars);
		return mav(mav, cmd, vars);
	}

	/**
	 * 찾기 화면
	 * 
	 * @param cmd
	 * @return
	 * @throws Exception
	 */
	@GetMapping("/find")
	public ModelAndView find(@ModelAttribute(Constants.CMD_VALUE) C cmd, @PathVariable Map<String, String> vars) throws Exception {
		ModelAndView mav = new ModelAndView();
		this.view = "/list";

		preControl(cmd, mav, vars);
		wrapper(cmd, vars);

		cmd.setPage_use_yn(StringUtils.defaultIfEmpty(cmd.getPage_use_yn(), "Y"));
		cmd.setPage_count_use_yn(StringUtils.defaultIfEmpty(cmd.getPage_count_use_yn(), "Y"));

		/** pageing setting */
		if (cmd.getCurrent_page_no() <= 0) {
			cmd.setCurrent_page_no(1);
		}
		if (cmd.getRecord_count_per_page() <= 0) {
			cmd.setRecord_count_per_page(this.propertyService.getInt("pageUnit"));
		}
		if (cmd.getPage_size() <= 0) {
			cmd.setPage_size(this.propertyService.getInt("pageSize"));
		}

		PaginationInfo paginationInfo = new PaginationInfo();
		paginationInfo.setCurrentPageNo(cmd.getCurrent_page_no());
		paginationInfo.setRecordCountPerPage(cmd.getRecord_count_per_page());
		paginationInfo.setPageSize(cmd.getPage_size());

		cmd.setFirst_index(paginationInfo.getFirstRecordIndex());
		cmd.setLast_index(paginationInfo.getLastRecordIndex());
		cmd.setRecord_count_per_page(paginationInfo.getRecordCountPerPage());

		mav.addObject(Constants.CMD_VALUE, service.getListFind(cmd));

		paginationInfo.setTotalRecordCount(cmd.getTotal_record_count());
		mav.addObject("paginationInfo", paginationInfo);

		postControl(cmd, mav, vars);
		return mav(mav, cmd, vars);
	}

	/**
	 * callback 화면
	 * 
	 * @param cmd
	 * @return
	 * @throws Exception
	 */
	@RequestMapping(value = { "/callback", "/{seq}/callback", "/write/callback", "/{seq}/write/callback", "/importdata/callback", "/importdata/write/callback", "/find/callback", "/mail/callback" })
	public ModelAndView callback(@ModelAttribute(Constants.CMD_VALUE) C cmd) throws Exception {
		return callback(Functions.getReq().getParameter(Constants.CALLBACK_VALUE));
	}

	/**
	 * 상세 조회 화면
	 * 
	 * @param cmd
	 * @param seq
	 * @return
	 * @throws Exception
	 */
	@GetMapping("/{seq}")
	public ModelAndView view(@ModelAttribute(Constants.CMD_VALUE) C cmd, @PathVariable Map<String, String> vars) throws Exception {
		ModelAndView mav = new ModelAndView();
		this.view = "/view";

		preControl(cmd, mav, vars);
		wrapper(cmd, vars);

		cmd.setSeq(Long.parseLong("" + vars.get("seq"), 10));
		cmd = this.service.getView(cmd);

		// 데이터가 없는경우 리스트 화면으로 강제 이동
		if (cmd == null) {
			mav.setViewName("redirect:" + getListUrl(cmd, vars) + "?" + Functions.getQueryString());
			return mav;
		}

		mav.addObject(Constants.CMD_VALUE, cmd);

		postControl(cmd, mav, vars);
		return mav(mav, cmd, vars);
	}

	/**
	 * 등록 화면 (Get)
	 * 
	 * @param cmd
	 * @return
	 * @throws Exception
	 * 
	 *             URL 패턴
	 *             /back/code -> LIST 화면
	 *             /back/code/1 -> VIEW 화면
	 *             /back/code/write -> INSERT 화면
	 *             /back/code/1/write -> UPDATE 화면
	 *             주의사항
	 *             /write 는 여러번 사용 금지
	 *             ex) /back/code/1/write/sub/write (X)
	 *             ex) /back/code/1/sub/write (O)
	 * 
	 */
	@GetMapping("/write")
	public ModelAndView insert(@ModelAttribute(Constants.CMD_VALUE) C cmd, @PathVariable Map<String, String> vars) throws Exception {
		this.view = "";

		ModelAndView mav = new ModelAndView();
		mav.addObject("isInsert", true);

		preControl(cmd, mav, vars);
		wrapper(cmd, vars);

		setProtectSubmit(Functions.getReq().getRequestURI());
		postControl(cmd, mav, vars);
		return mav(mav, cmd, vars);
	}

	/**
	 * 수정 화면 (Get)
	 * 
	 * @param cmd
	 * @param seq
	 * @return
	 * @throws Exception
	 * 
	 *             URL 패턴
	 *             /back/code -> LIST 화면
	 *             /back/code/1 -> VIEW 화면
	 *             /back/code/write -> INSERT 화면
	 *             /back/code/1/write -> UPDATE 화면
	 *             주의사항
	 *             /write 는 여러번 사용 금지
	 *             ex) /back/code/1/write/sub/write (X)
	 *             ex) /back/code/1/sub/write (O)
	 * 
	 */
	@GetMapping("/{seq}/write")
	public ModelAndView update(@ModelAttribute(Constants.CMD_VALUE) C cmd, @PathVariable Map<String, String> vars) throws Exception {
		this.view = "";

		ModelAndView mav = new ModelAndView();
		mav.addObject("isUpdate", true);

		preControl(cmd, mav, vars);
		wrapper(cmd, vars);

		cmd.setSeq(Long.parseLong("" + vars.get("seq"), 10));
		cmd = this.service.getView(cmd);

		// 데이터가 없는경우 리스트 화면으로 강제 이동
		if (cmd == null) {
			mav.setViewName("redirect:" + getListUrl(cmd, vars) + "?" + Functions.getQueryString());
			return mav;
		}

		mav.addObject(Constants.CMD_VALUE, cmd);

		setProtectSubmit(Functions.getReq().getRequestURI());
		postControl(cmd, mav, vars);
		return mav(mav, cmd, vars);
	}

	/**
	 * 등록 처리 (Post)
	 * 
	 * 
	 * 유효성 검사 (server-side)
	 * 
	 * @ModelAttribute 에 alias를 지정하지 않는다. (각 프로그램별 validation 처리를 위함)
	 *                 ex) <form:form modelAttribute="cmd" name="codeCommand" enctype="multipart/form-data" action="${url }" onsubmit="return doSubmit(this, 'post');">
	 * 
	 * 
	 * @param cmd
	 * @param multireq
	 * @param bindingResult
	 * @return
	 * @throws FileNotFoundException
	 * @throws IOException
	 * @throws Exception
	 */
	@PostMapping("/write")
	public String insert(@ModelAttribute C cmd, final MultipartHttpServletRequest multireq, BindingResult bindingResult, @PathVariable Map<String, String> vars) throws FileNotFoundException, IOException, Exception {
		view = "";

		preControl(cmd, null, vars);
		wrapper(cmd, vars);

		this.beanValidator.validate(cmd, bindingResult); // validation 수행
		if (bindingResult.hasErrors()) { // 만일 validation 에러가 있으면...
			return redirectCallback("/..", "/validator");
		}

		if (isProtectSubmit(Functions.getReq().getRequestURI())) {
			final Map<String, List<MultipartFile>> files = multireq.getMultiFileMap();
			// input=file 이 UI에 존재하는경우 attach_idx는 모두 부여된다.
			if (!files.isEmpty()) {
				cmd.setAttach_idx(this.attachUtil.upload(files.get("files_attach_idx"), null, this.thumb_yn, this.thumb_size));
				cmd.setAttach_idx_main(this.attachUtil.upload(files.get("files_attach_idx_main"), null, this.thumb_main_yn, this.thumb_main_size));
				cmd.setAttach_idx_sub1(this.attachUtil.upload(files.get("files_attach_idx_sub1"), null, this.thumb_sub1_yn, this.thumb_sub1_size));
				cmd.setAttach_idx_sub2(this.attachUtil.upload(files.get("files_attach_idx_sub2"), null, this.thumb_sub2_yn, this.thumb_sub2_size));
				cmd.setAttach_idx_sub3(this.attachUtil.upload(files.get("files_attach_idx_sub3"), null, this.thumb_sub3_yn, this.thumb_sub3_size));
				cmd.setAttach_idx_sub4(this.attachUtil.upload(files.get("files_attach_idx_sub4"), null, this.thumb_sub4_yn, this.thumb_sub4_size));
				cmd.setAttach_idx_sub5(this.attachUtil.upload(files.get("files_attach_idx_sub5"), null, this.thumb_sub5_yn, this.thumb_sub5_size));
			}

			this.service.insert(cmd);
		}

		postControl(cmd, null, vars);
		return redirect(getListUrl(cmd, vars));
	}

	/**
	 * 수정 처리 (Post - not Patch/Put)
	 * 
	 * patch/put 으로 처리해야하나 multipart 처리 인경우 post 밖에 처리가 되지 않는다.
	 * 
	 * 유효성 검사 (server-side)
	 * 
	 * @ModelAttribute 에 alias를 지정하지 않는다. (각 프로그램별 validation 처리를 위함)
	 *                 ex) <form:form modelAttribute="cmd" name="codeCommand" enctype="multipart/form-data" action="${url }" onsubmit="return doSubmit(this, 'post');">
	 * 
	 * @param cmd
	 * @param seq
	 * @param multireq
	 * @param bindingResult
	 * @return
	 * @throws FileNotFoundException
	 * @throws IOException
	 * @throws Exception
	 */
	@PostMapping("/{seq}/write")
	public String update(@ModelAttribute C cmd, final MultipartHttpServletRequest multireq, BindingResult bindingResult, @PathVariable Map<String, String> vars) throws FileNotFoundException, IOException, Exception {
		cmd.setSeq(Long.parseLong("" + vars.get("seq"), 10));
		this.view = "";

		preControl(cmd, null, vars);
		wrapper(cmd, vars);

		this.beanValidator.validate(cmd, bindingResult); // validation 수행
		if (bindingResult.hasErrors()) { // 만일 validation 에러가 있으면...
			return redirectCallback("/..", "/validator");
		}

		if (isProtectSubmit(Functions.getReq().getRequestURI())) {

			final Map<String, List<MultipartFile>> files = multireq.getMultiFileMap();
			if (!files.isEmpty()) {
				// insert 당시 attach_idx 가 없었다면 첨부파일을 사용하지 않았다는것이다.
				if (cmd.getAttach_idx() != null) {
					cmd.setAttach_idx(this.attachUtil.upload(files.get("files_attach_idx"), cmd.getAttach_idx(), this.thumb_yn, this.thumb_size));
				}
				if (cmd.getAttach_idx_main() != null) {
					cmd.setAttach_idx_main(this.attachUtil.upload(files.get("files_attach_idx_main"), cmd.getAttach_idx_main(), this.thumb_main_yn, this.thumb_main_size));
				}
				if (cmd.getAttach_idx_sub1() != null) {
					cmd.setAttach_idx_sub1(this.attachUtil.upload(files.get("files_attach_idx_sub1"), cmd.getAttach_idx_sub1(), this.thumb_sub1_yn, this.thumb_sub1_size));
				}
				if (cmd.getAttach_idx_sub2() != null) {
					cmd.setAttach_idx_sub2(this.attachUtil.upload(files.get("files_attach_idx_sub2"), cmd.getAttach_idx_sub2(), this.thumb_sub2_yn, this.thumb_sub2_size));
				}
				if (cmd.getAttach_idx_sub3() != null) {
					cmd.setAttach_idx_sub3(this.attachUtil.upload(files.get("files_attach_idx_sub3"), cmd.getAttach_idx_sub3(), this.thumb_sub3_yn, this.thumb_sub3_size));
				}
				if (cmd.getAttach_idx_sub4() != null) {
					cmd.setAttach_idx_sub4(this.attachUtil.upload(files.get("files_attach_idx_sub4"), cmd.getAttach_idx_sub4(), this.thumb_sub4_yn, this.thumb_sub4_size));
				}
				if (cmd.getAttach_idx_sub5() != null) {
					cmd.setAttach_idx_sub5(this.attachUtil.upload(files.get("files_attach_idx_sub5"), cmd.getAttach_idx_sub5(), this.thumb_sub5_yn, this.thumb_sub5_size));
				}
			}

			this.service.update(cmd);
		}

		postControl(cmd, null, vars);

		// *_view.jsp 페이지가 존재하는경우 상세 화면으로, 존재하지 않는경우 리스트 화면으로 이동
		// 마스터/슬레이브까지 지원하며 그 이상은 바로 리스트 화면으로 이동한다
		String include_servlet_path = (String) getListUrl(cmd, vars);
		if (include_servlet_path == null) {
			include_servlet_path = Functions.getReq().getServletPath();
		}
		if (vars != null) {
			// 정확한 replace 를 위해서 끝에 / 추가한다.
			include_servlet_path = include_servlet_path + "/";
			for (Entry<String, String> el : ((Map<String, String>) vars).entrySet()) {
				include_servlet_path = include_servlet_path.replaceFirst("/" + el.getValue() + "/", "/");
			}
			// 마지막에 추가한 / 를 제거한 값을 보낸다
			include_servlet_path = include_servlet_path.substring(0, include_servlet_path.length() - 1);
		}
		String[] ms = include_servlet_path.split("/");

		String pg_path = "/WEB-INF/jsp/iosf/com/program/" + ms[1] + "/extend/" + ms[2] + (ms.length > 3 ? "/" + ms[3] : "") + "/" + ms[2] + (ms.length > 3 ? "_" + ms[3] : "") + "_view.jsp";
		URL url = Functions.getReq().getServletContext().getResource(pg_path);
		if (url == null) {
			// 존재하지않는경우 extend 가 아닌 폴더에서 찾는다
			pg_path = pg_path.replaceAll("/extend", "");
			url = Functions.getReq().getServletContext().getResource(pg_path);
		}
		return redirect(url == null ? getListUrl(cmd, vars) : getListUrl(cmd, vars) + "/" + cmd.getSeq(), null);
	}

	/**
	 * 리스트 일부 수정 처리 (Patch)
	 * 
	 * @param cmd
	 * @return
	 * @throws Exception
	 */
	@PatchMapping()
	public String updateList(@ModelAttribute C cmd, @PathVariable Map<String, String> vars) throws Exception {
		preControl(cmd, null, vars);
		wrapper(cmd, vars);

		this.service.updateList(cmd);

		postControl(cmd, null, vars);
		return redirectCallback("/save");
	}

	/**
	 * 리스트 전체 수정 처리 (Put)
	 * 
	 * @param cmd
	 * @return
	 * @throws Exception
	 */
	@PutMapping()
	public String updateListForAll(@ModelAttribute C cmd, @PathVariable Map<String, String> vars) throws Exception {
		preControl(cmd, null, vars);
		wrapper(cmd, vars);

		this.service.updateListForAll(cmd);

		postControl(cmd, null, vars);
		return redirectCallback("/save");
	}

	/**
	 * 삭제로직 (Delete)
	 * 
	 * 리스트에서 삭제는 iframe 으로 처리하는것을 기본으로 한다.
	 * 상세화면, 수정화면에서의 삭제는 리스트로 이동한다.
	 * 
	 * @param cmd
	 * @param seqs
	 * @return
	 * @throws Exception
	 */
	@DeleteMapping(value = { "", "/{seq}", "/{seq}/write" })
	public String delete(@ModelAttribute C cmd, @PathVariable Map<String, String> vars) throws Exception {
		preControl(cmd, null, vars);
		wrapper(cmd, vars);

		boolean isList = vars.get("seq") == null;

		if (isList) {
			this.service.deleteList(cmd);
		} else {
			cmd.setSeq(Long.parseLong("" + vars.get("seq"), 10));
			this.service.delete(cmd);
		}

		postControl(cmd, null, vars);
		return isList ? redirectCallback("/delete") : redirect(getListUrl(cmd, vars), null);
	}

	/**
	 * Service 얻기
	 * 
	 * @return the service
	 */
	public S getService() {
		return this.service;
	}

	public Object getService(String service) {
		return ApplicationHelper.getService(service, Functions.getReq().getServletContext());
	}

	/**
	 * 프로그램의 리스트 화면
	 * 
	 * 최상위 리스트 화면은 아님
	 * /write 는 URL 패턴상 1개만 포함될수 있으므로 replace 한 후 마지막 / 전까지 사용한다
	 * 
	 * @param cmd
	 * @return
	 */
	protected String getListUrl(C cmd, @PathVariable Map<String, String> vars) {
		String url = Functions.getReq().getServletPath().replaceAll("/write", "");
		return vars.get("seq") == null ? url : url.substring(0, url.lastIndexOf("/"));
	}
}
