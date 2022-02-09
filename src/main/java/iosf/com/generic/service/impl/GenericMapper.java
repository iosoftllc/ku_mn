package iosf.com.generic.service.impl;

import java.util.List;

import org.apache.ibatis.session.RowBounds;

import iosf.com.generic.web.GenericCommand;

public interface GenericMapper<C extends GenericCommand> {

	public int getListCount(C cmd) throws Exception;

	public int getListFindCount(C cmd) throws Exception;

	public int getListCount_TEST(C cmd) throws Exception;

	public List<C> getList(C cmd, RowBounds row) throws Exception;

	public List<C> getList(C cmd) throws Exception;

	public List<C> getListFind(C cmd) throws Exception;

	public List<C> getList_TEST(C cmd) throws Exception;

	public C getView(C cmd) throws Exception;

	public Long insert(C cmd) throws Exception;

	public int update(C cmd) throws Exception;

	public int updateList(C cmd) throws Exception;

	public int updateListForAll(C cmd) throws Exception;

	public int delete(C cmd) throws Exception;

	public int deleteList(C cmd) throws Exception;
}
