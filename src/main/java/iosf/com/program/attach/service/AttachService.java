package iosf.com.program.attach.service;

import iosf.com.generic.service.GenericService;
import iosf.com.program.attach.web.AttachCommand;

public interface AttachService extends GenericService<AttachCommand> {
	public void download(AttachCommand cmd) throws Exception;

	public void download(AttachCommand cmd, boolean isDB) throws Exception;

	public void preview(AttachCommand cmd) throws Exception;
}
