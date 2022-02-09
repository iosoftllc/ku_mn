package iosf.com.program.extend.faq.web;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;

import iosf.com.generic.web.GenericController;
import iosf.com.program.extend.faq.service.FaqService;

@Controller
@RequestMapping("/front/faq")
public class FaqController extends GenericController<FaqService, FaqCommand> {

}
