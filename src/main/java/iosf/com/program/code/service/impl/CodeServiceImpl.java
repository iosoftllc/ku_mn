package iosf.com.program.code.service.impl;

import java.util.List;

import org.apache.commons.lang3.StringUtils;
import org.springframework.stereotype.Service;

import iosf.com.generic.service.impl.GenericServiceImpl;
import iosf.com.program.code.service.CodeService;
import iosf.com.program.code.web.CodeCommand;

@Service("codeService")
public class CodeServiceImpl extends GenericServiceImpl<CodeMapper, CodeCommand> implements CodeService {
	public List<CodeCommand> getCodes(CodeCommand cmd) throws Exception {
		return getMapper().getCodes(cmd);
	}

	public String getCheck(CodeCommand cmd) throws Exception {
		return getMapper().getCheck(cmd);
	}

	public int deleteCode(CodeCommand cmd) throws Exception {
		return getMapper().deleteCode(cmd);
	}

	@Override
	public int updateListForAll(CodeCommand cmd) throws Exception {

		CodeCommand _cmd = new CodeCommand();
		_cmd.setUp_cd_seq(cmd.getUp_cd_seq());
		getMapper().deleteCode(_cmd);
		if (cmd.getCd_ids() != null) {
			for (int i = 0; i < cmd.getCd_ids().length; i++) {
				if (StringUtils.isEmpty(cmd.getCd_ids()[i])) {
					continue;
				}
				_cmd.setCd_id(cmd.getCd_ids()[i]);
				_cmd.setCd_nm(cmd.getCd_nms()[i]);
				_cmd.setUse_yn(cmd.getUse_yns()[i]);
				_cmd.setLock_yn(cmd.getLock_yns()[i]);
				// getParameterValues()는 name이 여러개인경우와 1개인경우 value값이 있어야 받아온다.
				_cmd.setMemo(cmd.getMemos().length > 0 ? cmd.getMemos()[i] : "");
				_cmd.setOrd_no(i + 1);
				setUser(_cmd);
				getMapper().insert(_cmd);
			}
		}
		return 1;
	}
}
