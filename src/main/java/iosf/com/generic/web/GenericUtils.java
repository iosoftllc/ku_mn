package iosf.com.generic.web;

import java.lang.reflect.ParameterizedType;
import java.lang.reflect.Type;

public class GenericUtils {
	@SuppressWarnings("rawtypes")
	public static Class getClassOfGenericTypeIn(Class clazz, int index) {
		ParameterizedType genericSuperclass = (ParameterizedType) clazz.getGenericSuperclass();
		Type type = (Type) genericSuperclass.getActualTypeArguments()[index];
		if (type instanceof ParameterizedType) {
			return (Class) ((ParameterizedType) type).getRawType();
		} else {
			return (Class) type;
		}
	}
}