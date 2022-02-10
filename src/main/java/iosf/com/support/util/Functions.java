package iosf.com.support.util;

import java.awt.geom.AffineTransform;
import java.awt.image.AffineTransformOp;
import java.awt.image.BufferedImage;
import java.beans.BeanInfo;
import java.beans.IntrospectionException;
import java.beans.Introspector;
import java.beans.PropertyDescriptor;
import java.io.BufferedReader;
import java.io.File;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.lang.reflect.InvocationTargetException;
import java.lang.reflect.Method;
import java.math.BigInteger;
import java.net.InetAddress;
import java.net.URL;
import java.net.URLDecoder;
import java.net.URLEncoder;
import java.net.UnknownHostException;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.sql.Timestamp;
import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.util.HashMap;
import java.util.LinkedHashMap;
import java.util.Locale;
import java.util.Map;
import java.util.Map.Entry;
import java.util.UUID;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import javax.imageio.ImageIO;
import javax.net.ssl.HostnameVerifier;
import javax.net.ssl.HttpsURLConnection;
import javax.net.ssl.SSLContext;
import javax.net.ssl.SSLSession;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.commons.lang.StringUtils;
import org.json.simple.JSONObject;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.MessageSource;
import org.springframework.context.NoSuchMessageException;
import org.springframework.stereotype.Component;
import org.springframework.ui.freemarker.FreeMarkerTemplateUtils;
import org.springframework.web.context.request.RequestContextHolder;
import org.springframework.web.context.request.ServletRequestAttributes;
import org.springframework.web.servlet.support.RequestContextUtils;

import com.drew.imaging.ImageMetadataReader;
import com.drew.imaging.ImageProcessingException;
import com.drew.metadata.Directory;
import com.drew.metadata.Metadata;
import com.drew.metadata.MetadataException;
import com.drew.metadata.exif.ExifIFD0Directory;
import com.ibm.icu.util.ChineseCalendar;

import egovframework.com.cmm.LoginVO;
import egovframework.com.cmm.util.EgovUserDetailsHelper;
import freemarker.template.Configuration;
import iosf.com.program.user.web.UserCommand;
import iosf.com.sys.Codes;
import iosf.com.sys.Configs;
import iosf.com.sys.Constants;

@Component
public class Functions {

	private static final Logger LOGGER = LoggerFactory.getLogger(Functions.class);
	private static MessageSource ms;

	/**
	 * 다국어
	 * 
	 * @param messageSource
	 */
	@Autowired
	public void setMessageSource(MessageSource messageSource) {
		ms = messageSource;
	}

	/**
	 * 다국어
	 * 
	 * @return
	 */
	public static MessageSource getMessageSource() {
		return ms;
	}

	/**
	 * 앞에 특정 숫자 채우기
	 * 
	 * @param n
	 * @param length
	 * @param prefix
	 * @return
	 */
	public static String lPad(int n, int length, String prefix) {
		StringBuffer padded = new StringBuffer("" + n);
		while (padded.length() < length) {
			padded.insert(0, prefix);
		}
		return padded.toString();
	}

	/**
	 * UUID 추출
	 * 
	 * @param day
	 * @return
	 */
	public static String uuid() {
		UUID randomUUID = UUID.randomUUID();
		return randomUUID.toString();
	}

	/**
	 * QueryString 파라메터 추출
	 * 
	 * @return
	 */
	public static String getQueryString() {
		return getQueryString(null);
	}

	/**
	 * QueryString 파라메터 추출 (구분자 : 세미콜론(;))
	 * 
	 * @param paramException
	 * @return
	 */
	public static String getQueryString(String paramException) {
		String query = getReq().getQueryString();
		if (StringUtils.isEmpty(query) || (!StringUtils.isEmpty(paramException) && "*".equals(paramException))) {
			return "";
		}

		// 인터셉터에서 print를 위한 layout을 동적으로 잡을때 사용하는 layout_sub 키값이 URL에 붙는 현상 제거
		paramException = paramException == null ? "layout_sub" : paramException + ";layout_sub";

		query = getCleanXSS(query);
		LOGGER.debug("		:: Functions QueryString : " + query);

		String[] params = query.split("&");
		String key = "";
		String value = "";
		String ret = "";
		LOGGER.debug("		:: Functions QueryString paramException : " + paramException);

		for (int i = 0; i < params.length; i++) {
			String[] p = params[i].split("=");

			if (p.length <= 1) {
				continue;
			}

			key = p[0];
			value = p[1];
			LOGGER.debug("		:: Functions QueryString Exception [KEY] : " + key + "		[VALUE] : " + value);

			if ("CSRFToken".equals(key)) {
				continue;
			}

			if (!StringUtils.isEmpty(paramException)) {
				String[] pe = paramException.split(";");
				boolean bAdd = false;
				for (int j = 0; j < pe.length; j++) {
					if (!StringUtils.isEmpty(pe[j])) {
						if (pe[j].startsWith("*")) {
							if (key.endsWith(pe[j].substring(1))) {
								LOGGER.debug("		:: Functions QueryString Exception First * [KEY] : " + key + "		[Compare KEY] : " + pe[j]);
								bAdd = true;
								continue;
							}
						} else if (pe[j].endsWith("*")) {
							if (key.startsWith(pe[j].substring(0, pe[j].length() - 1))) {
								LOGGER.debug("		:: Functions QueryString Exception Last * [KEY] : " + key + "		[Compare KEY] : " + pe[j]);
								bAdd = true;
								continue;
							}
						} else {
							LOGGER.debug("		:: Functions QueryString Exception [KEY] : " + key + "		[Compare KEY] : " + pe[j]);
							if (pe[j].equals(key)) {
								bAdd = true;
								continue;
							}
						}
					}
				}
				if (bAdd) {
					continue;
				}
			}

			ret += (ret.length() > 0 ? "&" : "") + key + "=" + value;
		}
		LOGGER.debug("		:: Functions QueryString : " + ret);
		return ret;
	}

	/**
	 * 컴포넌트 HTML 얻기
	 * 
	 * @param c
	 * @return
	 * @throws Exception
	 */
	public static String getComponents(String c, Map<String, Object> map) throws Exception {
		Configuration freemarkerConfiguration = (Configuration) ApplicationHelper.getService("freemarkerConfiguration", getReq().getSession().getServletContext());
		// freemarker를 미리 bean 에서 로드해 놓으면 web 영역이 아니라서 servletcontext가 없는것같으므로 아래 셋팅을 추가
		freemarkerConfiguration.setServletContextForTemplateLoading(getReq().getSession().getServletContext(), Configs.UI_PATH + "/");
		String html = FreeMarkerTemplateUtils.processTemplateIntoString(freemarkerConfiguration.getTemplate(c + (Functions.getLanguage().contains("en") ? "_en" : "") + ".ftl", "UTF-8"), map);
		if (html == null) {
			html = FreeMarkerTemplateUtils.processTemplateIntoString(freemarkerConfiguration.getTemplate(c + ".ftl", "UTF-8"), map);
			if (html == null) {
				throw new Exception("		:: Not Found Components for " + c);
			}
		}
		return html;
	}

	/**
	 * 모바일 여부
	 * 
	 * @return
	 */
	public static boolean isMobile() {
		String ua = getReq().getHeader("user-agent").toLowerCase();
		String[] devices = { "iphone", "ipod", "ipad", "android", "blackberry", "windows ce", "nokia", "webos", "opera mini", "sonyericsson", "opera mobi", "iemobile" };
		for (String d : devices) {
			if (ua.contains(d)) {
				return true;
			}
		}
		return false;
	}

	/**
	 * 사용자 정보 얻기
	 * 
	 * @return
	 */
	public static UserCommand getUser() {
		Object obj = EgovUserDetailsHelper.getAuthenticatedUser();
		if (obj != null) {
			HttpServletRequest req = ((ServletRequestAttributes) RequestContextHolder.getRequestAttributes()).getRequest();
			if (req.getSession().getAttribute(Constants.SESSION_USERINFO) == null) {
				return ((LoginVO) obj).getInfo();
			}
			return (UserCommand) req.getSession().getAttribute(Constants.SESSION_USERINFO);
		}
		return null;
	}

	/**
	 * 현재 언어 가져오기 (2자리수)
	 * 
	 * @return
	 */
	public static String getLanguage() {
		return RequestContextUtils.getLocale(getReq()).toString().substring(0, 2).toLowerCase();
	}

	/**
	 * jquery params 형태로 리턴
	 * 
	 * @return
	 */
	public static String getJQueryParams(String params) {
		return params.replaceAll("&", "', ").replaceAll("=", " : '") + "'";
	}

	/**
	 * 신규 여부
	 * 
	 * @param datetime
	 * @param period
	 * @return
	 */
	public static boolean isNew(String datetime, String period) {
		if (StringUtils.isEmpty(period)) {
			period = "" + Configs.NEW_DAY;
		}

		try {
			Calendar nd = Calendar.getInstance();
			Calendar wd = Calendar.getInstance();

			DateFormat df = new SimpleDateFormat("yyyyMMddHHmmss");
			Date dt = df.parse(datetime);
			wd.setTime(dt);
			wd.add(Calendar.DATE, Integer.parseInt(period));

			if (nd.getTimeInMillis() <= wd.getTimeInMillis()) {
				return true;
			}
		} catch (ParseException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}

		return false;
	}

	/**
	 * 내용 줄바꿈 처리
	 * 
	 * @param content
	 * @return
	 */
	public static String getWrap(String content) {
		return content.replaceAll("\\n", "<br/>");
	}

	/**
	 * 다국어 번들
	 * 
	 * @param content
	 * @return
	 */
	public static String getMessage(String key) {
		return getMessage(key, null, null);
	}

	/**
	 * 다국어 번들
	 * 
	 * @param key
	 * @param loc
	 * @return
	 */
	public static String getMessage(String key, String args, Locale loc) {
		Locale _loc = loc;
		if (StringUtils.isEmpty(key)) {
			LOGGER.debug("		:: Funtions getMessage Key empty");
			return "";
		}
		String _key = key.trim().replaceAll(" ", "");
		_loc = _loc == null ? RequestContextUtils.getLocale(getReq()) : _loc;
		String ret = null;
		try {
			ret = getMessageSource().getMessage(_key, args == null ? null : args.split(","), _loc);
		} catch (NoSuchMessageException e) {
			LOGGER.debug("		:: Funtions getMessage Key not found");
		}
		// LOGGER.debug(" :: Funtions getMessage : [KEY] " + key + " [VALUE] " + ret + "
		// [LOCALE] " + _loc.toString());
		return ret == null ? key : ret;
	}

	/**
	 * MD5 암호화
	 * 
	 * @param data
	 * @return
	 * @throws NoSuchAlgorithmException
	 */
	public static String getMD5(String data) throws NoSuchAlgorithmException {
		MessageDigest messageDigest = MessageDigest.getInstance("MD5");
		messageDigest.update(data.getBytes(), 0, data.length());
		String hashed = new BigInteger(1, messageDigest.digest()).toString(16);
		if (hashed.length() < 32) {
			hashed = "0" + hashed;
		}

		return hashed;
	}

	/**
	 * 상세 코드값 반환
	 * 
	 * @param upcd
	 * @param cd
	 * @return
	 * @throws Exception
	 */
	public static String getCode(String upcd, String cd) throws Exception {
		return Codes.get(getReq().getSession().getServletContext(), upcd, cd);
	}

	/**
	 * 상세 코드 리스트 반환
	 * 
	 * @param upcd
	 * @param cd
	 * @return
	 * @throws Exception
	 */
	public static LinkedHashMap<String, String> getCodes(String upcd) throws Exception {
		LinkedHashMap<String, String> map = new LinkedHashMap<String, String>();
		if ("YN".equalsIgnoreCase(upcd)) {
			map.put("Y", "Y");
			map.put("N", "N");
		} else {
			map = Codes.get(getReq().getSession().getServletContext(), upcd);
		}

		return map;
	}

	/**
	 * 파일 종류 추출
	 * 
	 * @param prefix
	 * @param ext
	 * @return
	 */
	public static String getExtIcon(String prefix, String ext) {

		if (ext.contains(".xls")) {
			return prefix + "xls";
		} else if (ext.contains(".ppt")) {
			return prefix + "ppt";
		} else if (ext.contains(".doc")) {
			return prefix + "doc";
		} else if (ext.contains(".hwp")) {
			return prefix + "hwp";
		} else if (ext.contains(".pdf")) {
			return prefix + "pdf";
		} else if (ext.contains(".jpeg") || ext.contains(".jpg") || ext.contains(".png") || ext.contains(".gif")) {
			return prefix + "img";
		} else if (ext.contains(".zip")) {
			return prefix + "zip";
		}
		return "etc";
	}

	/**
	 * HTML 패턴
	 * 
	 * @author Administrator
	 *
	 */
	private static interface Patterns {
		// javascript tags and everything in between
		public static final Pattern SCRIPTS = Pattern.compile("<(no)?(?i)script[^>]*>.*?</(no)?(?i)script>", Pattern.DOTALL);
		public static final Pattern IFRAMES = Pattern.compile("<?(?i)iframe[^>]*>.*?</?(?i)iframe>", Pattern.DOTALL);
		public static final Pattern EMBEDS = Pattern.compile("<?(?i)embed[^>]*>.*?</?(?i)embed>", Pattern.DOTALL);

		public static final Pattern STYLE = Pattern.compile("<(?i)style[^>]*>.*</(?i)style>", Pattern.DOTALL);
		// HTML/XML tags
		public static final Pattern TAGS = Pattern.compile("<(\"[^\"]*\"|\'[^\']*\'|[^\'\">])*>");

		@SuppressWarnings("unused")
		public static final Pattern nTAGS = Pattern.compile("<\\w+\\s+[^<]*\\s*>");
		// entity references
		public static final Pattern ENTITY_REFS = Pattern.compile("&[^;]+;");
		// repeated whitespace
		public static final Pattern WHITESPACE = Pattern.compile("\\s\\s+");
		public static final Pattern XSS_HREF_SCRIPT = Pattern.compile("(?i)javascript(\\s\\s+)*?.?:");
		public static final Pattern XSS_EVAL = Pattern.compile("(?i)eval(\\s\\s+)*?.?\\((.*?)\\)");

		// html attributes
		public static final String[] XSS_TAG = { "!DOCTYPE"
				// , "a"
				, "abbr", "acronym", "address", "applet", "area", "article", "aside", "audio"
				// , "b"
				, "base", "basefont", "bdi", "bdo", "big", "blockquote", "body"
				// , "br"
				, "button", "canvas"
				// , "caption"
				// , "center"
				, "cite", "code"
				// , "col"
				// , "colgroup"
				, "data", "datalist"
				// , "dd"
				, "del", "details", "dfn", "dialog", "dir"
				// , "div"
				, "dl", "dt"
				// , "em"
				, "embed", "fieldset", "figcaption", "figure"
				// , "font"
				, "footer", "form", "frame", "frameset", "head"
				// , "header"
				// , "hr"
				, "html"
				// , "i"
				// , "iframe"
				// , "img"
				, "input"
				// , "ins"
				, "kbd"
				// , "label"
				, "legend"
				// , "li"
				, "link", "main", "map"
				// , "mark"
				, "meta", "meter", "nav", "noframes", "noscript", "object"
				// , "ol"
				, "optgroup", "option", "output"
				// , "p"
				, "param", "picture"
				// , "pre"
				, "progress"
				// , "q"
				, "rp", "rt", "ruby", "samp", "script", "section", "select"
				// , "small"
				, "source"
				// , "span"
				// , "strike"
				// , "strong"
				, "style"
				// , "sub"
				// , "summary"
				// , "sup"
				, "svg"
				// , "table"
				// , "tbody"
				// , "td"
				, "template", "textarea"
				// , "tfoot"
				// , "th"
				// , "thead"
				, "time", "title"
				// , "tr"
				, "track"
				// , "tt"
				// , "u"
				// , "ul"
				, "var"
				// , "video"
				, "wbr"
				// , "h1"
				// , "h2"
				// , "h3"
				// , "h4"
				// , "h5"
				// , "h6"
		};
		// public static final String[] XSS_TAG = { "script", "iframe", "embed" };
		public static final String[] XSS_STR = { "onabort", "onafterprint", "onanimationend", "onanimationiteration", "onanimationstart", "onbeforeprint", "onbeforeunload", "onblur", "oncanplay", "oncanplaythrough", "onchange", "onclick", "oncontextmenu", "oncopy", "oncut", "ondblclick", "ondrag", "ondragend", "ondragenter", "ondragleave", "ondragover", "ondragstart", "ondrop", "ondurationchange", "onended", "onerror", "onfocus", "onfocusin", "onfocusout", "onfullscreenchange", "onfullscreenerror", "onhashchange", "oninput", "oninvalid", "onkeydown", "onkeypress", "onkeyup", "onload", "onloadeddata", "onloadedmetadata", "onloadstart", "onmessage", "onmousedown", "onmouseenter", "onmouseleave", "onmousemove", "onmouseover", "onmouseout", "onmouseup", "onmousewheel", "onoffline", "ononline", "onopen", "onpagehide", "onpageshow", "onpaste", "onpause", "onplay", "onplaying", "onpopstate", "onprogress", "onratechange", "onresize", "onreset", "onscroll", "onsearch", "onseeked", "onseeking", "onselect", "onshow", "onstalled", "onstorage", "onsubmit", "onsuspend", "ontimeupdate", "ontoggle", "ontouchcancel", "ontouchend", "ontouchmove", "ontouchstart", "ontransitionend", "onunload", "onvolumechange", "onwaiting", "onwheel", "onbeforecopy", "onbeforecut", "onbeforepaste", "oncopy", "oncut", "oninput", "onkeydown", "onkeypress", "onkeyup", "onpaste", "onabort", "onbeforeunload", "onhashchange", "onload", "onoffline", "ononline", "onreadystatechange", "onstop", "onunload", "onreset", "onsubmit", "onclick", "oncontextmenu", "ondblclick", "onlosecapture", "onmouseenter", "onmousedown", "onmouseleave", "onmousemove", "onmouseout", "onmouseover", "onmouseup", "onmousewheel", "onscroll", "onmove", "onmoveend", "onmovestart", "ondrag", "ondragend", "ondragenter", "ondragleave", "ondragover", "ondragstart", "ondrop", "onresize", "onresizeend", "onresizestart", "onactivate", "onbeforeactivate", "onbeforedeactivate", "onbeforeeditfocus", "onblur", "ondeactivate", "onfocus", "onfocusin", "onfocusout", "oncontrolselect", "onselect", "onselectionchange", "onselectstart", "onbeforeprint", "onhelp", "onerror", "onerrorupdate", "onafterupdate", "onbeforeupdate", "oncellchange", "ondataavailable", "ondatasetchanged", "ondatasetcomplete", "onrowenter", "onrowexit", "onrowsdelete", "onrowsinserted", "onbounce", "onfinish", "onstart", "onchange", "onfilterchange", "onpropertychange", "onsearch", "onmessage" };
	}

	/**
	 * HTML 포멧 제거
	 * 
	 * @param s
	 * @return
	 */
	public static String getCleanHTML(String s) {
		if (s == null) {
			return null;
		}

		Matcher m;

		m = Patterns.SCRIPTS.matcher(s);
		s = m.replaceAll("");
		m = Patterns.STYLE.matcher(s);
		s = m.replaceAll("");
		m = Patterns.TAGS.matcher(s);
		s = m.replaceAll("");
		m = Patterns.ENTITY_REFS.matcher(s);
		s = m.replaceAll("");
		m = Patterns.WHITESPACE.matcher(s);
		s = m.replaceAll(" ");

		return s;
	}

	/**
	 * XSS 필터
	 * 
	 * @param s
	 * @return
	 */
	public static String getCleanXSS(String s) {
		if (s == null) {
			return null;
		}

		String value = s;
		Matcher m;
		// value = value.replaceAll("<", "& lt;").replaceAll(">", "& gt;");
		// value = value.replaceAll("\\(", "& #40;").replaceAll("\\)", "& #41;");
		// value = value.replaceAll("'", "& #39;");

		m = Patterns.SCRIPTS.matcher(value);
		value = m.replaceAll("");
		m = Patterns.IFRAMES.matcher(value);
		// value = m.replaceAll("");
		m = Patterns.EMBEDS.matcher(value);
		// value = m.replaceAll("");
		m = Patterns.XSS_HREF_SCRIPT.matcher(value);
		value = m.replaceAll("");
		m = Patterns.XSS_EVAL.matcher(value);
		value = m.replaceAll("");
		for (int i = 0; i < Patterns.XSS_TAG.length; i++) {
			Pattern XSS_EVENT = Pattern.compile("<(\\s\\s+)*?(?i)" + Patterns.XSS_TAG[i] + ".*?");
			m = XSS_EVENT.matcher(value);
			value = m.replaceAll("");
		}
		for (int i = 0; i < Patterns.XSS_STR.length; i++) {
			Pattern XSS_EVENT = Pattern.compile("(?i)" + Patterns.XSS_STR[i] + "(\\s\\s+)*?.?=");
			m = XSS_EVENT.matcher(value);
			value = m.replaceAll("");
		}

		m = Patterns.SCRIPTS.matcher(value);
		if (m.find()) {
			value = getCleanXSS(value);
		}
		m = Patterns.XSS_HREF_SCRIPT.matcher(value);
		if (m.find()) {
			value = getCleanXSS(value);
		}
		m = Patterns.XSS_EVAL.matcher(value);
		if (m.find()) {
			value = getCleanXSS(value);
		}
		for (int i = 0; i < Patterns.XSS_TAG.length; i++) {
			Pattern XSS_EVENT = Pattern.compile("<(\\s\\s+)*?(?i)" + Patterns.XSS_TAG[i] + ".*?");
			m = XSS_EVENT.matcher(value);
			if (m.find()) {
				value = getCleanXSS(value);
			}
		}
		for (int i = 0; i < Patterns.XSS_STR.length; i++) {
			Pattern XSS_EVENT = Pattern.compile("(?i)" + Patterns.XSS_STR[i] + ".*?=");
			m = XSS_EVENT.matcher(value);
			if (m.find()) {
				value = getCleanXSS(value);
			}
		}
		return value;
	}

	/**
	 * JSON 포멧 제거
	 * 
	 * @param s
	 * @return
	 */
	public static String getCleanJSON(String s) {
		if (s == null) {
			return null;
		}

		return s.replace("\\\\/", "\\/").replace("\\\"", "&#34;").replace("\\r\\n", "<br/>").replace("\\n", "<br/>").replace("\\\\", "\\");
	}

	/**
	 * URLEncoder
	 * 
	 * @param s
	 * @return
	 * @throws UnsupportedEncodingException
	 */
	public static String getURLEncode(String s) throws UnsupportedEncodingException {
		if (s == null) {
			return null;
		}

		try {
			return URLEncoder.encode(s, "UTF-8");
		} catch (Exception e) {
			return "";
		}
	}

	/**
	 * URLDecoder
	 * 
	 * @param s
	 * @return
	 * @throws UnsupportedEncodingException
	 */
	public static String getURLDecode(String s) throws UnsupportedEncodingException {
		if (s == null) {
			return null;
		}

		return URLDecoder.decode(s, "UTF-8");
	}

	/**
	 * 날짜 구하기
	 * 
	 * @param format
	 * @return
	 */
	public static String getDate(String now, String format, String field, String amount) {
		try {
			DateFormat df = new SimpleDateFormat(format);
			Calendar cal = Calendar.getInstance();

			if (!StringUtils.isEmpty(now)) {
				now = now.replaceAll("-", "").replaceAll("/", "").replaceAll("\\.", "").replaceAll(" ", "");
				if (now.length() >= 8) {
					if (now.length() >= 14) {
						cal.set(Integer.parseInt(now.substring(0, 4)), Integer.parseInt(now.substring(4, 6)) - 1, Integer.parseInt(now.substring(6, 8)), Integer.parseInt(now.substring(8, 10)), Integer.parseInt(now.substring(10, 12)), Integer.parseInt(now.substring(12, 14)));
					} else {
						cal.set(Integer.parseInt(now.substring(0, 4)), Integer.parseInt(now.substring(4, 6)) - 1, Integer.parseInt(now.substring(6, 8)));
					}
				}
			}
			// 월요일 기준
			cal.setFirstDayOfWeek(Calendar.MONDAY);

			if (!StringUtils.isEmpty(field) && !StringUtils.isEmpty(amount)) {
				int _amount = Integer.parseInt(amount);
				if ("Y".equalsIgnoreCase(field)) {
					cal.add(Calendar.YEAR, _amount);
				}
				if ("M".equalsIgnoreCase(field)) {
					cal.add(Calendar.MONTH, _amount);
				}
				if ("D".equalsIgnoreCase(field)) {
					cal.add(Calendar.DATE, _amount);
				}
			}
			Date d = cal.getTime();
			return df.format(d);
		} catch (Exception e) {
			return "getDate() Error";
		}
	}

	public static String getDate(String format) {
		return getDate(null, format, null, null);
	}

	/**
	 * 응용어플리케이션에서 고유값을 사용하기 위해 시스템에서17자리의TIMESTAMP값을 구하는 기능
	 *
	 * @param
	 * @return Timestamp 값
	 * @see
	 */
	public static String getTimeStamp() {
		// 문자열로 변환하기 위한 패턴 설정(년도-월-일 시:분:초:초(자정이후 초))
		String pattern = "yyyyMMddhhmmssSSS";

		SimpleDateFormat sdfCurrent = new SimpleDateFormat(pattern, Locale.KOREA);
		Timestamp ts = new Timestamp(System.currentTimeMillis());

		return sdfCurrent.format(ts.getTime());
	}

	/**
	 * Beans 를 Map 으로 변환
	 * 
	 * @param obj
	 * @return
	 * @throws IntrospectionException
	 * @throws IllegalArgumentException
	 * @throws IllegalAccessException
	 * @throws InvocationTargetException
	 */
	public static Map<String, Object> getBeanToMap(Object obj) throws IntrospectionException, IllegalArgumentException, IllegalAccessException, InvocationTargetException {

		Map<String, Object> map = new HashMap<String, Object>();

		BeanInfo info = Introspector.getBeanInfo(obj.getClass());
		for (PropertyDescriptor pd : info.getPropertyDescriptors()) {
			Method reader = pd.getReadMethod();
			if (reader != null)
				map.put(pd.getName(), reader.invoke(obj));
		}

		return map;
	}

	/**
	 * JSTL 문자열 붙이기
	 * 
	 * @param pre
	 * @param post
	 * @param append
	 * @return
	 */
	public static String concat(String pre, String post, String append) {
		return pre + append + post;
	}

	/**
	 * 이미지 로테이션 (메터데이터 기준)
	 * 
	 * @param save_path
	 * @return
	 * @throws ImageProcessingException
	 * @throws IOException
	 * @throws MetadataException
	 */
	public static BufferedImage correctOrientation(String save_path) throws ImageProcessingException, IOException, MetadataException {
		File inputStream = new File(save_path.replaceAll("/", "\\" + File.separator));
		Metadata metadata = ImageMetadataReader.readMetadata(inputStream);
		if (metadata != null) {
			if (metadata.containsDirectoryOfType(ExifIFD0Directory.class)) {
				// Get the current orientation of the image
				Directory directory = metadata.getFirstDirectoryOfType(ExifIFD0Directory.class);
				int orientation = directory.getInt(ExifIFD0Directory.TAG_ORIENTATION);

				// Create a buffered image from the input stream
				BufferedImage bimg = ImageIO.read(inputStream);

				// Get the current width and height of the image
				int[] imageSize = { bimg.getWidth(), bimg.getHeight() };
				int width = imageSize[0];
				int height = imageSize[1];

				// Determine which correction is needed
				AffineTransform t = new AffineTransform();
				switch (orientation) {
				case 1:
					// no correction necessary skip and return the image
					return bimg;
				case 2: // Flip X
					t.scale(-1.0, 1.0);
					t.translate(-width, 0);
					return transform(bimg, t, orientation);
				case 3: // PI rotation
					t.translate(width, height);
					t.rotate(Math.PI);
					return transform(bimg, t, orientation);
				case 4: // Flip Y
					t.scale(1.0, -1.0);
					t.translate(0, -height);
					return transform(bimg, t, orientation);
				case 5: // - PI/2 and Flip X
					t.rotate(-Math.PI / 2);
					t.scale(-1.0, 1.0);
					return transform(bimg, t, orientation);
				case 6: // -PI/2 and -width
					t.translate(height, 0);
					t.rotate(Math.PI / 2);
					return transform(bimg, t, orientation);
				case 7: // PI/2 and Flip
					t.scale(-1.0, 1.0);
					t.translate(height, 0);
					t.translate(0, width);
					t.rotate(3 * Math.PI / 2);
					return transform(bimg, t, orientation);
				case 8: // PI / 2
					t.translate(0, width);
					t.rotate(3 * Math.PI / 2);
					return transform(bimg, t, orientation);
				}
			}
		}

		return null;
	}

	/**
	 * Performs the tranformation
	 * 
	 * @param bimage
	 * @param transform
	 * @return
	 * @throws IOException
	 */
	private static BufferedImage transform(BufferedImage bimage, AffineTransform transform, int orientation) throws IOException {
		// Create an transformation operation
		AffineTransformOp op = new AffineTransformOp(transform, AffineTransformOp.TYPE_BICUBIC);

		// Create an instance of the resulting image, with the same width, height and
		// image type than the referenced one
		int w = bimage.getWidth();
		int h = bimage.getHeight();
		BufferedImage destinationImage = new BufferedImage(orientation == 6 || orientation == 8 ? h : w, orientation == 6 || orientation == 8 ? w : h, bimage.getType());
		op.filter(bimage, destinationImage);

		return destinationImage;
	}

	/**
	 * 음력날짜를 양력날짜로 변환
	 * 
	 * @param 음력날짜
	 *            (yyyyMMdd)
	 * @return 양력날짜 (yyyyMMdd)
	 */
	@SuppressWarnings("unused")
	private static String convertLunarToSolar(String date) {
		ChineseCalendar cc = new ChineseCalendar();
		Calendar cal = Calendar.getInstance();
		SimpleDateFormat sdf = new SimpleDateFormat("yyyyMMdd");

		cc.set(ChineseCalendar.EXTENDED_YEAR, Integer.parseInt(date.substring(0, 4)) + 2637);
		cc.set(ChineseCalendar.MONTH, Integer.parseInt(date.substring(4, 6)) - 1);
		cc.set(ChineseCalendar.DAY_OF_MONTH, Integer.parseInt(date.substring(6)));

		cal.setTimeInMillis(cc.getTimeInMillis());
		return sdf.format(cal.getTime());
	}

	/**
	 * 양력날짜를 음력날짜로 변환
	 * 
	 * @param 양력날짜
	 *            (yyyyMMdd)
	 * @return 음력날짜 (yyyyMMdd)
	 */
	@SuppressWarnings("unused")
	private static String converSolarToLunar(String date) {
		ChineseCalendar cc = new ChineseCalendar();
		Calendar cal = Calendar.getInstance();

		cal.set(Calendar.YEAR, Integer.parseInt(date.substring(0, 4)));
		cal.set(Calendar.MONTH, Integer.parseInt(date.substring(4, 6)) - 1);
		cal.set(Calendar.DAY_OF_MONTH, Integer.parseInt(date.substring(6)));

		cc.setTimeInMillis(cal.getTimeInMillis());

		int y = cc.get(ChineseCalendar.EXTENDED_YEAR) - 2637;
		int m = cc.get(ChineseCalendar.MONTH) + 1;
		int d = cc.get(ChineseCalendar.DAY_OF_MONTH);

		return String.format("%04d", y) + String.format("%02d", m) + String.format("%02d", d);
	}

	/**
	 * Request 구하기
	 * 
	 * @return
	 */
	public static HttpServletRequest getReq() {
		return ((ServletRequestAttributes) RequestContextHolder.getRequestAttributes()).getRequest();
	}

	/**
	 * Response 구하기
	 * 
	 * @return
	 */
	public static HttpServletResponse getRes() {
		return ((ServletRequestAttributes) RequestContextHolder.getRequestAttributes()).getResponse();
	}

	/**
	 * 
	 * 
	 * @param returnUrl
	 * @param param
	 * @param req
	 * @return
	 * @throws Exception
	 */
	public static String httpsURLConnection(String url_addr, Map<String, String> headers, JSONObject param) throws Exception {
		return httpsURLConnection(url_addr, headers, param, "POST");
	}

	public static String httpsURLConnection(String url_addr, Map<String, String> headers, JSONObject param, String method) throws Exception {

		LOGGER.debug("	:: HTTPS URL Connection");

		StringBuffer results = new StringBuffer();
		try {
			BufferedReader br;

			// Not Weblogic
			URL url = new URL(url_addr);

			// Weblogic
			// @SuppressWarnings("restriction")
			// URL url = new URL(null, returnUrl, new sun.net.www.protocol.https.Handler());

			HttpsURLConnection huc = (HttpsURLConnection) url.openConnection();
			huc.setHostnameVerifier(new HostnameVerifier() {
				@Override
				public boolean verify(String hostname, SSLSession session) {
					// TODO Auto-generated method stub
					return true;
				}
			});
			huc.setDoInput(true);
			if (method == null || "POST".equalsIgnoreCase(method)) {
				huc.setDoOutput(true);
			}
			huc.setUseCaches(false);
			huc.setReadTimeout(3000); // 상대방 서버 통신 오류로 인해 접속 지연시 강제로 timeout 처리; 현재 5초 대기
			huc.setConnectTimeout(3000); // 상대방 서버 통신 오류로 인해 접속 지연시 강제로 timeout 처리; 현재 5초 대기
			huc.setRequestMethod(method);
			for (Entry<String, String> el : ((Map<String, String>) headers).entrySet()) {
				huc.setRequestProperty(el.getKey(), el.getValue());
			}

			// BufferedWriter bw = new BufferedWriter(new OutputStreamWriter(huc.getOutputStream()));
			// bw.write(param.toString());
			// bw.flush();
			// bw.close();

			int response_code = huc.getResponseCode();

			SSLContext context = SSLContext.getInstance("TLS");
			context.init(null, null, null);
			huc.setSSLSocketFactory(context.getSocketFactory());

			huc.connect();
			huc.setInstanceFollowRedirects(true);

			LOGGER.debug("	:: HTTPS URL Connection Request OK");

			// 응답받은 메시지의 길이만큼 버퍼를 생성하여 읽어들임; Response
			String inputLine;

			LOGGER.debug("	:: HTTPS URL Connection Response Code : " + huc.getResponseCode());
			switch (response_code) {
			case HttpsURLConnection.HTTP_OK: // 200
				br = new BufferedReader(new InputStreamReader(huc.getInputStream(), "UTF-8"));

				while ((inputLine = br.readLine()) != null) {
					LOGGER.debug("	:: HTTPS URL Connection Line : " + inputLine);
					results.append(inputLine);
				}
				break;
			case HttpsURLConnection.HTTP_MOVED_TEMP: // 302
				br = null;
				break;
			default:
				br = new BufferedReader(new InputStreamReader(huc.getErrorStream(), "UTF-8"));
				while ((inputLine = br.readLine()) != null) {
					LOGGER.debug("	:: HTTPS URL Connection Line : " + inputLine);
					results.append(inputLine);
				}
				break;
			}

			br.close();

		} catch (Exception e) {
			e.printStackTrace();
		} finally {
		}

		LOGGER.debug("	:: HTTPS URL Connection Result : " + results.toString());
		return results.toString();
	}

	/**
	 * Command 내에 있는 _dt나 _time 으로 끝나는 메소드에 대해서 yyyyMMddHHmmss 형태로 만들어준다.
	 * 
	 * @param cmd
	 * @throws IllegalAccessException
	 * @throws IllegalArgumentException
	 * @throws InvocationTargetException
	 */
	public static void formatDateTimeForCommand(Object cmd) throws IllegalAccessException, IllegalArgumentException, InvocationTargetException {
		Method methods[] = cmd.getClass().getMethods();

		Map<String, String> map = new HashMap<String, String>();
		for (int i = 0; i < methods.length; i++) {
			String findMethod = methods[i].getName();

			if (findMethod.startsWith("get") && (findMethod.endsWith("_dt") || findMethod.endsWith("_time"))) {
				String value = (String) methods[i].invoke(cmd);
				if (value == null) {
					continue;
				}

				map.put(findMethod.substring(3), value);
			}
		}
		for (int i = 0; i < methods.length; i++) {
			if (map == null || map.size() <= 0) {
				break;
			}

			String findMethod = methods[i].getName();

			if (findMethod.startsWith("set") && findMethod.endsWith("_dt")) {
				String dt = map.get(findMethod.substring(3));

				if (dt == null) {
					continue;
				}
				dt = dt.replaceAll("-", "");

				// 시간도 입력되었다면
				String time = map.get(findMethod.substring(3).replace("_dt", "_time"));
				if (time != null) {
					time = time.replaceAll(":", "");
					String time_add = "";
					for (int z = 0; z < (6 - time.length()); z++) {
						time_add += "0";
					}
					// 6자리로 만든다.
					time += time_add;

					// 일자와 시간을 합친다.
					dt += time;
				}

				methods[i].invoke(cmd, dt);
			}
		}
	}

	public static long getDDay(String sdt, String edt) throws ParseException {
		Date sdate = new SimpleDateFormat("yyyyMMdd").parse(sdt);
		Date edate = new SimpleDateFormat("yyyyMMdd").parse(edt);
		Calendar scal = Calendar.getInstance();
		scal.setTime(sdate);
		Calendar ecal = Calendar.getInstance();
		ecal.setTime(edate);

		long diffSec = (ecal.getTimeInMillis() - scal.getTimeInMillis()) / 1000;
		long diffDays = diffSec / (24 * 60 * 60); // 일수 차이
		return diffDays;
	}

	public static String getServerIp() {
		InetAddress local = null;
		try {
			local = InetAddress.getLocalHost();
		} catch (UnknownHostException e) {
			e.printStackTrace();
		}

		if (local == null) {
			return "";
		} else {
			String ip = local.getHostAddress();
			return ip;
		}
	}

	public static String getClientIP() {
		String ip = getReq().getHeader("X-Forwarded-For");

		if (ip == null) {
			ip = getReq().getHeader("Proxy-Client-IP");
		}
		if (ip == null) {
			ip = getReq().getHeader("WL-Proxy-Client-IP");
		}
		if (ip == null) {
			ip = getReq().getHeader("HTTP_CLIENT_IP");
		}
		if (ip == null) {
			ip = getReq().getHeader("HTTP_X_FORWARDED_FOR");
		}
		if (ip == null) {
			ip = getReq().getRemoteAddr();
		}

		return ip;
	}
}