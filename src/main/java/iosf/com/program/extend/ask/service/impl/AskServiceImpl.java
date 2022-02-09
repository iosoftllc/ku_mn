package iosf.com.program.extend.ask.service.impl;

import org.springframework.stereotype.Service;

import iosf.com.generic.service.impl.GenericServiceImpl;
import iosf.com.program.extend.ask.service.AskService;
import iosf.com.program.extend.ask.web.AskCommand;

@Service("askService")
public class AskServiceImpl extends GenericServiceImpl<AskMapper, AskCommand> implements AskService {

}
