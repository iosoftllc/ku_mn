package iosf.com.support.util;

import java.util.Base64;

import javax.crypto.Cipher;
import javax.crypto.SecretKey;
import javax.crypto.SecretKeyFactory;
import javax.crypto.spec.DESedeKeySpec;

/**
 * 서브원 복호화 소스 (배포용)
 * 
 * @author 고려대학교 전산개발부
 */
public class DecodeEncryptorLocal168 {

	/**
	 * 서브원 프로그램에 해당하는 KEY 암호화 할때와 복호화 할때 해당 KEY 값이 일치해야 한다.
	 */
	private final static String KEY = "local.korea.ac.kr163.152.7.214";

	public static byte[] decode(String encrypted) throws Exception {
		return Base64.getMimeDecoder().decode(encrypted.getBytes("UTF-8"));
	}

	public static String decodeRandomKey(String randomKey) {
		String ciphers = "aBcDeFgHiJ";
		String key = "";

		for (int i = 0; i < randomKey.length(); i++) {
			int index = ciphers.indexOf(randomKey.substring(i, i + 1));
			if (index < 0)
				key = key.concat(".");
			else
				key = key.concat(String.valueOf(index));
		}

		return key;
	}

	public static String findRandomKey(String encrypted) {
		return encrypted.substring(encrypted.lastIndexOf(".") - 1);
	}

	public static String findOriginData(String encrypted) {
		return encrypted.substring(0, encrypted.lastIndexOf(".") - 1);
	}

	public static String decrypt(byte[] keydata, byte[] data) {
		try {
			DESedeKeySpec keySpec = new DESedeKeySpec(keydata);
			SecretKeyFactory keyFactory = SecretKeyFactory.getInstance("DESede");
			SecretKey desKey = keyFactory.generateSecret(keySpec);

			Cipher cipher = Cipher.getInstance("DESede/ECB/PKCS5Padding");
			cipher.init(Cipher.DECRYPT_MODE, desKey);

			byte[] decryptedText = cipher.doFinal(data);
			String output = new String(decryptedText, "UTF8");

			return output;
		} catch (Exception e) {
			e.printStackTrace();
			return null;
		}
	}

	/**
	 * 암호화된 값을 복호화 한다.
	 * 
	 * @param encrypted 암호화로 전달된 파라미터
	 * @return String
	 */
	public static String getDecryptedValue(String encrypted) {

		String decrypted = "";

		try {
			String customKey = KEY + decodeRandomKey(findRandomKey(encrypted));

			decrypted = decrypt(customKey.getBytes(), decode(findOriginData(encrypted)));

		} catch (Exception e) {
			e.printStackTrace();
		}

		return decrypted;
	}

	public static void main(String[] args) {

		DecodeEncryptorLocal168 encryptor168 = new DecodeEncryptorLocal168();

		// 테스트로 암호화 한 값
		String encrypted = "T9heRyGjXYqinn9HQa+fJTxuy3JGA7jI7jmbM5HebiZJLR3iQQtIH6iJHoYC6s9A+m2O2rmpH8rAOwMr24MsvO9Tsh5RSVquoQE0tnN4RRTro5L5RC03LYHukbJpg93QMddAkx7IWra+aluzWcjDv35MXGpnzH6C5QOdMDECXWSDWAQfjIWdNoU9aH5B3w4KpBFx4ddZVw/8aZd8uIs7knRbw4XZ0w+xq4koqwAVd5c=a.HaFieDJDFgFaiigc";

		String decrypted = encryptor168.getDecryptedValue(encrypted);

		System.out.println("decrypt data : " + decrypted);

	}
}
