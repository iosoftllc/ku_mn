package iosf.com.program.extend.mobile.web;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;

import iosf.com.generic.web.GenericController;
import iosf.com.program.extend.mobile.service.MobileService;

@Controller
@RequestMapping("/front/mobile")
public class MobileController extends GenericController<MobileService, MobileCommand> {

}
