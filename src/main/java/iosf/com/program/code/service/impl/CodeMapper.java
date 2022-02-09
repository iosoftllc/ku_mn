package iosf.com.program.code.service.impl;

import java.util.List;

import iosf.com.generic.service.impl.GenericMapper;
import iosf.com.program.code.web.CodeCommand;

public interface CodeMapper extends GenericMapper<CodeCommand> {
	public List<CodeCommand> getCodes(CodeCommand cmd) throws Exception;

	public String getCheck(CodeCommand cmd) throws Exception;

	public int deleteCode(CodeCommand cmd) throws Exception;
}
