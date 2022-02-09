package iosf.com.program.code.service;

import java.util.List;

import iosf.com.generic.service.GenericService;
import iosf.com.program.code.web.CodeCommand;

public interface CodeService extends GenericService<CodeCommand> {
	public List<CodeCommand> getCodes(CodeCommand cmd) throws Exception;

	public String getCheck(CodeCommand cmd) throws Exception;

	public int deleteCode(CodeCommand cmd) throws Exception;
}
