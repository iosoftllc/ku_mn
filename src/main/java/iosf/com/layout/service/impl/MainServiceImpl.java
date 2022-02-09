package iosf.com.layout.service.impl;

import org.springframework.stereotype.Service;

import iosf.com.generic.service.impl.GenericServiceImpl;
import iosf.com.layout.service.MainService;
import iosf.com.layout.web.MainCommand;

@Service("mainService")
public class MainServiceImpl extends GenericServiceImpl<MainMapper, MainCommand> implements MainService {

}
