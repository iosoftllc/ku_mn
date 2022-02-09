package iosf.com.generic.service;

import iosf.com.generic.web.GenericCommand;

public interface GenericService<C extends GenericCommand> {

	public C getList(C cmd) throws Exception;

	public C getListFind(C cmd) throws Exception;

	public C getView(C cmd) throws Exception;

	public Long insert(C cmd) throws Exception;

	public int update(C cmd) throws Exception;

	public int updateList(C cmd) throws Exception;

	public int updateListForAll(C cmd) throws Exception;

	public int delete(C cmd) throws Exception;

	public int deleteList(C cmd) throws Exception;
}
