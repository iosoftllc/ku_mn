package iosf.com.program.extend.ask.web;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;

import iosf.com.generic.web.GenericController;
import iosf.com.program.extend.ask.service.AskService;

@Controller
@RequestMapping("/front/ask")
public class AskController extends GenericController<AskService, AskCommand> {

}
