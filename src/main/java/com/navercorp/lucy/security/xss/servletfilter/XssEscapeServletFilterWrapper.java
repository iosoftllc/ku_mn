/*
 * Copyright 2014 NAVER Corp.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

package com.navercorp.lucy.security.xss.servletfilter;

import java.util.HashMap;
import java.util.Map;
import java.util.Map.Entry;
import java.util.Set;

import javax.servlet.ServletRequest;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletRequestWrapper;

/**
 * @author todtod80
 * @author leeplay
 */
public class XssEscapeServletFilterWrapper extends HttpServletRequestWrapper {
	private XssEscapeFilter xssEscapeFilter;
	private String path = null;
	// & -> &amp; 로 대체하는 패턴
	private String[][] noTagList = { { "&", "#", "<", ">", "\"", "\\(", "\\)" }, { "&amp;", "&#35;", "&lt;", "&gt;", "&quot;", "&#40;", "&#41;" } };

	public XssEscapeServletFilterWrapper(ServletRequest request, XssEscapeFilter xssEscapeFilter) {
		super((HttpServletRequest) request);
		this.xssEscapeFilter = xssEscapeFilter;
		this.path = ((HttpServletRequest) request).getRequestURI();
	}

	@Override
	public String getParameter(String paramName) {
		String value = super.getParameter(paramName);
		value = doFilter(paramName, value);
		// 파라메터 content 가 포함되지 않으면 HTML 태그 자체를 허용하지 않는다.
		if (value != null) {
			for (int i = 0; i < noTagList[0].length; i++) {
				String text = noTagList[0][i];
				value = value.replaceAll(text, noTagList[1][i]);
			}
		}
		return value;
	}

	@Override
	public String[] getParameterValues(String paramName) {
		String values[] = super.getParameterValues(paramName);
		if (values == null) {
			return values;
		}
		for (int index = 0; index < values.length; index++) {
			values[index] = doFilter(paramName, values[index]);

			// 파라메터 content 가 포함되지 않으면 HTML 태그 자체를 허용하지 않는다.
			if (values[index] != null) {
				for (int i = 0; i < noTagList[0].length; i++) {
					String text = noTagList[0][i];
					values[index] = values[index].replaceAll(text, noTagList[1][i]);
				}
			}
		}
		return values;
	}

	@Override
	public Map<String, String[]> getParameterMap() {
		Map<String, String[]> paramMap = super.getParameterMap();
		Map<String, String[]> newFilteredParamMap = new HashMap<String, String[]>();

		Set<Entry<String, String[]>> entries = paramMap.entrySet();
		for (Entry<String, String[]> entry : entries) {
			String paramName = entry.getKey();
			String[] value = (String[]) entry.getValue();
			String[] filteredValue = new String[value.length];
			for (int index = 0; index < value.length; index++) {
				filteredValue[index] = doFilter(paramName, String.valueOf(value[index]));

				if (filteredValue[index] != null) {
					for (int i = 0; i < noTagList[0].length; i++) {
						String text = noTagList[0][i];
						filteredValue[index] = filteredValue[index].replaceAll(text, noTagList[1][i]);
					}
				}
			}

			newFilteredParamMap.put(entry.getKey(), filteredValue);
		}

		return newFilteredParamMap;
	}

	/**
	 * @param paramName
	 *            String
	 * @param value
	 *            String
	 * @return String
	 */
	private String doFilter(String paramName, String value) {
		return xssEscapeFilter.doFilter(path, paramName, value);
	}
}
