import egovframework.com.cmm.util.EgovMybaitsUtil;

public class DbFunctions {
	public static boolean isEmpty(Object o) throws IllegalArgumentException {
		return EgovMybaitsUtil.isEmpty(o);
	}

	public static boolean isNotEmpty(Object o) {
		return EgovMybaitsUtil.isNotEmpty(o);
	}

	public static boolean isEquals(Object o1, Object o2) {
		return EgovMybaitsUtil.isEquals(o1, o2);
	}

	public static boolean isNotEquals(Object o1, Object o2) {
		return EgovMybaitsUtil.isNotEquals(o1, o2);
	}

	public static boolean isEqualsStr(Object o, String s) {
		return EgovMybaitsUtil.isEqualsStr(o, s);
	}
}
