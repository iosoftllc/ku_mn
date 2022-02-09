package iosf.com.generic.service.impl;

import javax.annotation.Resource;

import org.apache.commons.lang.StringUtils;
import org.apache.ibatis.session.SqlSession;

import egovframework.com.cmm.util.EgovUserDetailsHelper;
import egovframework.rte.fdl.cmmn.EgovAbstractServiceImpl;
import iosf.com.generic.service.GenericService;
import iosf.com.generic.web.GenericCommand;
import iosf.com.generic.web.GenericUtils;
import iosf.com.program.attach.util.AttachUtil;
import iosf.com.program.user.web.UserCommand;
import iosf.com.support.util.ApplicationHelper;
import iosf.com.support.util.Functions;
import iosf.com.sys.Constants;

@SuppressWarnings({ "rawtypes" })
public class GenericServiceImpl<M extends GenericMapper, C extends GenericCommand> extends EgovAbstractServiceImpl implements GenericService<C> {

	@Resource(name = "iosf.sqlSessionTemplate")
	protected SqlSession sqlSession;
	@Resource(name = "iosf.sqlSessionTemplate.se")
	protected SqlSession sqlSessionSe;
	@Resource(name = "attachUtil")
	protected AttachUtil attachUtil;

	protected void logging(C cmd) {
		egovLogger.debug("		:: Service : " + getClass().getName());
		egovLogger.debug("		:: MapperClass : " + getMapper().getClass().getName());
		egovLogger.debug("		:: CommandClass : " + cmd.getClass().getName());
	}

	/**
	 * 사용자 정보
	 * 
	 * @return
	 */
	public UserCommand getUser() {
		UserCommand cmd = (UserCommand) EgovUserDetailsHelper.getAuthenticatedUser();
		if (cmd != null) {
			return (UserCommand) Functions.getReq().getSession().getAttribute(Constants.SESSION_USERINFO);
		}

		return null;
	}

	/**
	 * 등록/수정 사용자 정보 셋팅
	 * 
	 * @param cmd
	 * @return
	 */
	public C setUser(C cmd) {
		UserCommand _cmd = getUser();
		if (_cmd != null) {
			cmd.setReg_id(_cmd.getUser_id());
			cmd.setReg_nm(_cmd.getUser_nm());
			cmd.setMod_id(_cmd.getUser_id());
			cmd.setMod_nm(_cmd.getUser_nm());
		} else {
			cmd.setReg_id("SYSTEM");
			cmd.setReg_nm("SYSTEM");
			cmd.setMod_id("SYSTEM");
			cmd.setMod_nm("SYSTEM");
		}
		cmd.setUser_ip(Functions.getClientIP());

		return cmd;
	}

	/**
	 * 리스트
	 */
	@SuppressWarnings("unchecked")
	public C getList(C cmd) throws Exception {
		M mapper = getMapper();
		// search_start_dt, search_end_dt 변수는 자동 날짜타입으로 맞춘다.
		if (!StringUtils.isEmpty(cmd.getSearch_start_dt())) {
			cmd.setSearch_start_dt(Functions.getDate(cmd.getSearch_start_dt() + "000000", "yyyyMMddHHmmss", null, null));
		}
		if (!StringUtils.isEmpty(cmd.getSearch_end_dt())) {
			cmd.setSearch_end_dt(Functions.getDate(cmd.getSearch_end_dt() + "235959", "yyyyMMddHHmmss", null, null));
		}

		cmd.setTest_yn(StringUtils.isEmpty(cmd.getTest_yn()) ? "N" : cmd.getTest_yn());

		cmd.setList("N".equals(cmd.getTest_yn()) ? mapper.getList(cmd) : mapper.getList_TEST(cmd));

		if ("Y".equals(StringUtils.defaultIfEmpty(cmd.getPage_use_yn(), "N")) && "Y".equals(StringUtils.defaultIfEmpty(cmd.getPage_count_use_yn(), "N"))) {
			cmd.setTotal_record_count("N".equals(cmd.getTest_yn()) ? mapper.getListCount(cmd) : mapper.getListCount_TEST(cmd));
		} else {
			cmd.setTotal_record_count(cmd.getList().size());
		}

		return cmd;
	}

	/**
	 * 찾기 화면 리스트
	 */
	@SuppressWarnings("unchecked")
	public C getListFind(C cmd) throws Exception {
		M mapper = getMapper();
		if ("Y".equals(cmd.getFind_query_use_yn())) {
			// Find 쿼리 별도 정의하여 사용
			cmd.setList(mapper.getListFind(cmd));
			cmd.setTotal_record_count(mapper.getListFindCount(cmd));
		} else {
			cmd = getList(cmd);
		}
		return cmd;
	}

	/**
	 * 상세 조회
	 */
	@SuppressWarnings("unchecked")
	public C getView(C cmd) throws Exception {
		M mapper = getMapper();

		return (C) mapper.getView(cmd);
	}

	/**
	 * 등록
	 */
	@SuppressWarnings("unchecked")
	public Long insert(C cmd) throws Exception {
		M mapper = getMapper();
		setUser(cmd);

		return mapper.insert(cmd);
	}

	/**
	 * 수정
	 */
	@SuppressWarnings("unchecked")
	public int update(C cmd) throws Exception {
		M mapper = getMapper();
		setUser(cmd);

		return mapper.update(cmd);
	}

	/**
	 * 일부 리스트 수정
	 * 
	 * id_checks 변수 사용
	 * 같은 데이터로 통일 저장시 사용한다
	 * row별 각각 다른 데이터로 저장시 Override 하여 로직을 구성한다
	 * 
	 * ex)
	 * deleteList(cmd);
	 * for (int i = 0 ; i < cmd.getSeqs().length ; i ++) {
	 * Command _cmd = new Command();
	 * _cmd.setSeq(cmd.getSeqs()[i]);
	 * _cmd.setData(cmd.getData()[i]);
	 * update(_cmd);
	 * }
	 */
	@SuppressWarnings("unchecked")
	public int updateList(C cmd) throws Exception {
		M mapper = getMapper();
		setUser(cmd);

		return mapper.updateList(cmd);
	}

	/**
	 * 전체 리스트 수정
	 * 
	 * ids 변수 사용
	 * 같은 데이터로 통일 저장시 사용한다
	 * row별 각각 다른 데이터로 저장시 Override 하여 로직을 구성한다
	 * 
	 * ex)
	 * deleteList(cmd);
	 * for (int i = 0 ; i < cmd.getSeqs().length ; i ++) {
	 * Command _cmd = new Command();
	 * _cmd.setSeq(cmd.getSeqs()[i]);
	 * _cmd.setData(cmd.getData()[i]);
	 * update(_cmd);
	 * }
	 */
	@SuppressWarnings("unchecked")
	public int updateListForAll(C cmd) throws Exception {
		M mapper = getMapper();
		setUser(cmd);

		return mapper.updateListForAll(cmd);
	}

	/**
	 * 삭제
	 */
	@SuppressWarnings("unchecked")
	public int delete(C cmd) throws Exception {
		M mapper = getMapper();
		setUser(cmd);

		return mapper.delete(cmd);
	}

	/**
	 * 일부 리스트 삭제
	 */
	@SuppressWarnings("unchecked")
	public int deleteList(C cmd) throws Exception {
		M mapper = getMapper();
		setUser(cmd);

		return mapper.deleteList(cmd);
	}

	/**
	 * 데이터소스 선택
	 * true인 경우 second datasource 를 사용한다
	 * 
	 * @param isSe
	 * @return
	 */
	@SuppressWarnings("unchecked")
	public M getMapper(boolean isSe) {
		if (isSe) {
			return (M) sqlSessionSe.getMapper(GenericUtils.getClassOfGenericTypeIn(getClass(), 0));
		}
		return (M) sqlSession.getMapper(GenericUtils.getClassOfGenericTypeIn(getClass(), 0));
	}

	/**
	 * 클래스명이 ImplSe 인 경우 second datasource 를 자동으로 사용한다
	 * ImplSe가 아닌 클래스라도 getMapper(true) 로 지정시 second datasource 를 사용할 수 있다.
	 * 
	 * @return
	 */
	public M getMapper() {
		if (getClass().getName().endsWith("ImplSe")) {
			return getMapper(true);
		}
		return getMapper(false);
	}

	/**
	 * 서비스 get
	 * 
	 * @param service
	 * @return
	 */
	public Object getService(String service) {
		return ApplicationHelper.getService(service, Functions.getReq().getServletContext());
	}
}