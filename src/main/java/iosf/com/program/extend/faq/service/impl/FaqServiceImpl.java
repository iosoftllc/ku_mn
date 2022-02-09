package iosf.com.program.extend.faq.service.impl;

import org.springframework.stereotype.Service;

import iosf.com.generic.service.impl.GenericServiceImpl;
import iosf.com.program.extend.faq.service.FaqService;
import iosf.com.program.extend.faq.web.FaqCommand;

@Service("faqService")
public class FaqServiceImpl extends GenericServiceImpl<FaqMapper, FaqCommand> implements FaqService {

}
