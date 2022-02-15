package iosf.com.program.extend.card.service.impl;

import org.springframework.stereotype.Service;

import iosf.com.generic.service.impl.GenericServiceImpl;
import iosf.com.program.extend.card.service.CardService;
import iosf.com.program.extend.card.web.CardCommand;

@Service("cardService")
public class CardServiceImpl extends GenericServiceImpl<CardMapper, CardCommand> implements CardService {
	@Override
	public CardCommand getList(CardCommand cmd) throws Exception {
		// TODO Auto-generated method stub
		cmd.setIdnos(getUser().getStd_ids());
		return super.getList(cmd);
	}
}
