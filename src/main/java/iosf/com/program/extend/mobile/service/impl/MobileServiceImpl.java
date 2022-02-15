package iosf.com.program.extend.mobile.service.impl;

import org.springframework.stereotype.Service;

import iosf.com.generic.service.impl.GenericServiceImpl;
import iosf.com.program.extend.mobile.service.MobileService;
import iosf.com.program.extend.mobile.web.MobileCommand;

@Service("mobileService")
public class MobileServiceImpl extends GenericServiceImpl<MobileMapper, MobileCommand> implements MobileService {
	@Override
	public MobileCommand getList(MobileCommand cmd) throws Exception {
		// TODO Auto-generated method stub
		cmd.setIdnos(getUser().getStd_ids());
		return super.getList(cmd);
	}
}
