package iosf.com.program.extend.notice.service.impl;

import iosf.com.generic.service.impl.GenericMapper;
import iosf.com.program.extend.notice.web.NoticeCommand;

public interface NoticeMapper extends GenericMapper<NoticeCommand> {
	public int updateHit(NoticeCommand cmd);
}
