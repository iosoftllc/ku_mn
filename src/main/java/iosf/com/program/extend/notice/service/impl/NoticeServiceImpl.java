package iosf.com.program.extend.notice.service.impl;

import org.springframework.stereotype.Service;

import iosf.com.generic.service.impl.GenericServiceImpl;
import iosf.com.program.extend.notice.service.NoticeService;
import iosf.com.program.extend.notice.web.NoticeCommand;

@Service("noticeService")
public class NoticeServiceImpl extends GenericServiceImpl<NoticeMapper, NoticeCommand> implements NoticeService {
	public int updateHit(NoticeCommand cmd) throws Exception {
		return getMapper().updateHit(cmd);
	}
}
