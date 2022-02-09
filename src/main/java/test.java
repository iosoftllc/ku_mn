import java.util.HashMap;
import java.util.Map;

import org.json.simple.JSONObject;

import iosf.com.support.util.Functions;

class Person {
	private String name;

	public Person(String name) {
		this.name = name;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}
}

class PersonService {
	public void pass1(Person p) {
		p.setName("엑소");
	}

	public void pass2(Person p) {
		p = new Person("방탄소년단");
	}
}

public class test {
	public static void main(String[] args) throws Exception {
		Person p = new Person("박서준");
		PersonService service = new PersonService();
		service.pass1(p);
		System.out.println(p.getName());
		service.pass2(p);
		System.out.println(p.getName());

		Map<String, String> headers = new HashMap<String, String>();
//		headers.put("reslifestdid", "2000250345");
//		headers.put("access_token", "70dd4542-541a-4c90-9536-384eb58968df");
		JSONObject root = new JSONObject();
		System.out.println(Functions.httpsURLConnection("https://openapi.korea.ac.kr/api/reslifeexamno?reslifestdid=2000250345&access_token=70dd4542-541a-4c90-9536-384eb58968df", headers, root, "GET"));
	}
}
