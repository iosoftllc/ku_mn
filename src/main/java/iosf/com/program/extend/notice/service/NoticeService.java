package iosf.com.program.extend.notice.service;

import iosf.com.generic.service.GenericService;
import iosf.com.program.extend.notice.web.NoticeCommand;

public interface NoticeService extends GenericService<NoticeCommand> {
	public int updateHit(NoticeCommand cmd) throws Exception;
}
