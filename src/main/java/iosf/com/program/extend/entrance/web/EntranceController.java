package iosf.com.program.extend.entrance.web;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;

import iosf.com.generic.web.GenericController;
import iosf.com.program.extend.entrance.service.EntranceService;

@Controller
@RequestMapping("/front/entrance")
public class EntranceController extends GenericController<EntranceService, EntranceCommand> {

}
