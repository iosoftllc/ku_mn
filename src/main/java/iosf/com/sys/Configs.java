package iosf.com.sys;

import java.io.File;

import javax.servlet.ServletContext;

import org.apache.commons.lang3.StringUtils;

import egovframework.com.cmm.service.EgovProperties;
import egovframework.rte.fdl.property.EgovPropertyService;
import iosf.com.support.util.ApplicationHelper;

public class Configs {

	public static boolean IS_REAL_SERVER = false;
	public static boolean IS_DELETE_FILE = false;

	public static String DEV_IP = "";
	public static String PROTOCOL = "";
	public static String DOMAIN = "";
	public static String CHARSET = "";
	public static String CONTEXT = "";
	public static String CONTEXT_WEB = "";
	public static String IMG_SRC = "";
	public static String CSS_SRC = "";
	public static String JS_SRC = "";
	public static String FORMAT_DATE = "";
	public static String FORMAT_DATEE = "";
	public static String FORMAT_DATETIME = "";
	public static String FORMAT_DATEETIME = "";
	public static String FORMAT_TIME = "";
	public static String FORMAT_TIMEE = "";
	public static String SUPER_ADMIN_ID = "";
	public static int PAGE_UNIT = 0;
	public static int PAGE_SIZE = 0;
	public static int NEW_DAY = 0;

	public static String ROOT_PATH = "";
	public static String WWW_PATH = "";
	public static String SAVE_PATH = "";
	public static String UI_PATH = "";
	public static String TEMP_PATH = "";
	public static String CONTENT_PATH = "";

	public static String SMTP_SERVER = "";
	public static int SMTP_PORT = 0;
	public static String FROM_EMAIL = "";
	public static String FROM_NAME = "";
	public static String MAIL_TITLE_PREFIX = "";
	public static String MAIL_ID = "";
	public static String MAIL_PW = "";
	public static String TEST_EMAIL = "";
	public static String POWER_PW = "";
	public static String MAILTEMPLATE_PATH = "";
	public static String REPORT_PATH = "";
	public static String IMPORTDATATEMPLATE_PATH = "";
	public static EgovPropertyService PROP;

	public Configs(ServletContext context) {
		EgovPropertyService service = (EgovPropertyService) ApplicationHelper.getService("propertiesService", context);
		IS_REAL_SERVER = service.getBoolean("is_real_server");
		IS_DELETE_FILE = service.getBoolean("is_delete_file");
		DEV_IP = service.getString("dev_ip");
		PROTOCOL = IS_REAL_SERVER ? service.getString("protocol") : service.getString("test_protocol");
		DOMAIN = IS_REAL_SERVER ? service.getString("domain") : service.getString("test_domain");
		CHARSET = service.getString("charset");
		CONTEXT = (StringUtils.isNotEmpty(service.getString("context")) && IS_REAL_SERVER) ? service.getString("context") : context.getContextPath();
		CONTEXT_WEB = (StringUtils.isNotEmpty(service.getString("context_web")) && IS_REAL_SERVER) ? service.getString("context_web") : context.getContextPath();
		IMG_SRC = service.getString("img_src");
		CSS_SRC = service.getString("css_src");
		JS_SRC = service.getString("js_src");
		FORMAT_DATE = service.getString("format_date");
		FORMAT_DATEE = service.getString("format_datee");
		FORMAT_DATETIME = service.getString("format_datetime");
		FORMAT_DATEETIME = service.getString("format_dateetime");
		FORMAT_TIME = service.getString("format_time");
		FORMAT_TIMEE = service.getString("format_timee");
		SUPER_ADMIN_ID = service.getString("super_admin_id");
		PAGE_UNIT = service.getInt("page_unit");
		PAGE_SIZE = service.getInt("page_size");
		NEW_DAY = service.getInt("new_day");
		WWW_PATH = service.getString("www_path");
		SAVE_PATH = service.getString("save_path");
		UI_PATH = service.getString("ui_path");
		TEMP_PATH = service.getString("temp_path");
		CONTENT_PATH = service.getString("content_path");
		MAILTEMPLATE_PATH = service.getString("mailtemplate_path");
		REPORT_PATH = service.getString("report_path");
		IMPORTDATATEMPLATE_PATH = service.getString("importdatatemplate_path");

		// 업로드 경로 생성
		ROOT_PATH = StringUtils.isEmpty(ROOT_PATH) ? context.getRealPath("").substring(0,  context.getRealPath("").length() - 1) : ROOT_PATH;
		File file = new File(ROOT_PATH);
		if (!file.exists()) {
			file.mkdir();
		}
		WWW_PATH = ROOT_PATH + WWW_PATH;
		file = new File(WWW_PATH);
		if (!file.exists()) {
			file.mkdir();
		}
		// global.properties 에서 경로 뒤에 / 가붙어있어 제외한다.
		SAVE_PATH = EgovProperties.getProperty("Globals.fileStorePath").substring(0, EgovProperties.getProperty("Globals.fileStorePath").length() - 1) + SAVE_PATH;
		file = new File(SAVE_PATH);
		if (!file.exists()) {
			file.mkdir();
		}
		TEMP_PATH = SAVE_PATH + TEMP_PATH;
		file = new File(TEMP_PATH);
		if (!file.exists()) {
			file.mkdir();
		}
		REPORT_PATH = ROOT_PATH + REPORT_PATH;
		file = new File(REPORT_PATH);
		if (!file.exists()) {
			file.mkdir();
		}
		CONTENT_PATH = ROOT_PATH + CONTENT_PATH;
		file = new File(CONTENT_PATH);
		if (!file.exists()) {
			file.mkdir();
		}

		FROM_EMAIL = service.getString("from_email");
		SMTP_SERVER = IS_REAL_SERVER ? service.getString("smtp_server") : service.getString("test_smtp_server");
		SMTP_PORT = IS_REAL_SERVER ? service.getInt("smtp_server_port") : service.getInt("test_smtp_server_port");
		FROM_NAME = service.getString("from_name");
		MAIL_TITLE_PREFIX = service.getString("mail_title_prefix");
		MAIL_ID = IS_REAL_SERVER ? service.getString("mail_id") : service.getString("test_mail_id");
		MAIL_PW = IS_REAL_SERVER ? service.getString("mail_pw") : service.getString("test_mail_pw");
		TEST_EMAIL = service.getString("test_email");
		POWER_PW = service.getString("power_pw");
		PROP = service;

		context.setAttribute(Constants.CONFIGS, this);
	}

	/**
	 * @return the iS_REAL_SERVER
	 */
	public final boolean isIS_REAL_SERVER() {
		return IS_REAL_SERVER;
	}

	/**
	 * @return the iS_DELETE_FILE
	 */
	public final boolean isIS_DELETE_FILE() {
		return IS_DELETE_FILE;
	}

	/**
	 * @return the dEV_IP
	 */
	public final String getDEV_IP() {
		return DEV_IP;
	}

	/**
	 * @return the pROTOCOL
	 */
	public final String getPROTOCOL() {
		return PROTOCOL;
	}

	/**
	 * @return the dOMAIN
	 */
	public final String getDOMAIN() {
		return DOMAIN;
	}

	/**
	 * @return the cHARSET
	 */
	public final String getCHARSET() {
		return CHARSET;
	}

	/**
	 * @return the cONTEXT
	 */
	public final String getCONTEXT() {
		return CONTEXT;
	}

	/**
	 * @return the cONTEXT_WEB
	 */
	public final String getCONTEXT_WEB() {
		return CONTEXT_WEB;
	}

	/**
	 * @return the iMG_SRC
	 */
	public final String getIMG_SRC() {
		return IMG_SRC;
	}

	/**
	 * @return the cSS_SRC
	 */
	public final String getCSS_SRC() {
		return CSS_SRC;
	}

	/**
	 * @return the jS_SRC
	 */
	public final String getJS_SRC() {
		return JS_SRC;
	}

	/**
	 * @return the fORMAT_DATE
	 */
	public final String getFORMAT_DATE() {
		return FORMAT_DATE;
	}

	/**
	 * @return the fORMAT_DATEE
	 */
	public final String getFORMAT_DATEE() {
		return FORMAT_DATEE;
	}

	/**
	 * @return the fORMAT_DATETIME
	 */
	public final String getFORMAT_DATETIME() {
		return FORMAT_DATETIME;
	}

	/**
	 * @return the fORMAT_DATEETIME
	 */
	public final String getFORMAT_DATEETIME() {
		return FORMAT_DATEETIME;
	}

	/**
	 * @return the fORMAT_TIME
	 */
	public final String getFORMAT_TIME() {
		return FORMAT_TIME;
	}

	/**
	 * @return the fORMAT_TIMEE
	 */
	public final String getFORMAT_TIMEE() {
		return FORMAT_TIMEE;
	}

	/**
	 * @return the sUPER_ADMIN_ID
	 */
	public final String getSUPER_ADMIN_ID() {
		return SUPER_ADMIN_ID;
	}

	/**
	 * @return the pAGE_UNIT
	 */
	public final int getPAGE_UNIT() {
		return PAGE_UNIT;
	}

	/**
	 * @return the pAGE_SIZE
	 */
	public final int getPAGE_SIZE() {
		return PAGE_SIZE;
	}

	/**
	 * @return the nEW_DAY
	 */
	public final int getNEW_DAY() {
		return NEW_DAY;
	}

	/**
	 * @return the rOOT_PATH
	 */
	public final String getROOT_PATH() {
		return ROOT_PATH;
	}

	/**
	 * @return the wWW_PATH
	 */
	public final String getWWW_PATH() {
		return WWW_PATH;
	}

	/**
	 * @return the sAVE_PATH
	 */
	public final String getSAVE_PATH() {
		return SAVE_PATH;
	}

	/**
	 * @return the uI_PATH
	 */
	public final String getUI_PATH() {
		return UI_PATH;
	}

	/**
	 * @return the tEMP_PATH
	 */
	public final String getTEMP_PATH() {
		return TEMP_PATH;
	}

	/**
	 * @return the cONTENT_PATH
	 */
	public final String getCONTENT_PATH() {
		return CONTENT_PATH;
	}

	/**
	 * @return the sMTP_SERVER
	 */
	public final String getSMTP_SERVER() {
		return SMTP_SERVER;
	}

	/**
	 * @return the sMTP_PORT
	 */
	public final int getSMTP_PORT() {
		return SMTP_PORT;
	}

	/**
	 * @return the fROM_EMAIL
	 */
	public final String getFROM_EMAIL() {
		return FROM_EMAIL;
	}

	/**
	 * @return the fROM_NAME
	 */
	public final String getFROM_NAME() {
		return FROM_NAME;
	}

	/**
	 * @return the mAIL_TITLE_PREFIX
	 */
	public final String getMAIL_TITLE_PREFIX() {
		return MAIL_TITLE_PREFIX;
	}

	/**
	 * @return the mAIL_ID
	 */
	public final String getMAIL_ID() {
		return MAIL_ID;
	}

	/**
	 * @return the mAIL_PW
	 */
	public final String getMAIL_PW() {
		return MAIL_PW;
	}

	/**
	 * @return the tEST_EMAIL
	 */
	public final String getTEST_EMAIL() {
		return TEST_EMAIL;
	}

	/**
	 * @return the pOWER_PW
	 */
	public final String getPOWER_PW() {
		return POWER_PW;
	}

	/**
	 * @return the mAILTEMPLATE_PATH
	 */
	public final String getMAILTEMPLATE_PATH() {
		return MAILTEMPLATE_PATH;
	}

	/**
	 * @return the rEPORT_PATH
	 */
	public final String getREPORT_PATH() {
		return REPORT_PATH;
	}

	/**
	 * @return the iMPORTDATATEMPLATE_PATH
	 */
	public final String getIMPORTDATATEMPLATE_PATH() {
		return IMPORTDATATEMPLATE_PATH;
	}

	/**
	 * @return the pROP
	 */
	public final EgovPropertyService getPROP() {
		return PROP;
	}
}
