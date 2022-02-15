package iosf.com.program.extend.card.web;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;

import iosf.com.generic.web.GenericController;
import iosf.com.program.extend.card.service.CardService;

@Controller
@RequestMapping("/front/card")
public class CardController extends GenericController<CardService, CardCommand> {

}
