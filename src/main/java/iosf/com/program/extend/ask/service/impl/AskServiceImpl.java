package iosf.com.program.extend.ask.service.impl;

import org.springframework.stereotype.Service;

import iosf.com.generic.service.impl.GenericServiceImpl;
import iosf.com.program.extend.ask.service.AskService;
import iosf.com.program.extend.ask.web.AskCommand;

@Service("askService")
public class AskServiceImpl extends GenericServiceImpl<AskMapper, AskCommand> implements AskService {
	@Override
	public AskCommand getList(AskCommand cmd) throws Exception {
		// TODO Auto-generated method stub
		cmd.setIdnos(getUser().getStd_ids());
		return super.getList(cmd);
	}

	@Override
	public Long insert(AskCommand cmd) throws Exception {
		// TODO Auto-generated method stub
		cmd.setIdno(getUser().getStd_id());
		return super.insert(cmd);
	}
}
