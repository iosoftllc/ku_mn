//	 사용예)
//	final FTPUtil ftputil = new FTPUtil();
//	ftputil.setCallback(new Callback() {
//		public void proc(FTPClient client) throws IOException {
//			// TODO Auto-generated method stub
//			ftputil.getList(client, "/");
//		}
//	});
//	  
//	ftputil.run(id, pw, charset, workdir);
package iosf.com.support.util;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.List;

import org.apache.commons.lang3.StringUtils;
import org.apache.commons.net.ftp.FTP;
import org.apache.commons.net.ftp.FTPClient;
import org.apache.commons.net.ftp.FTPCmd;
import org.apache.commons.net.ftp.FTPFile;
import org.apache.commons.net.ftp.FTPListParseEngine;
import org.apache.commons.net.ftp.FTPReply;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import egovframework.rte.fdl.cmmn.exception.EgovBizException;

public class FTPUtil {

	public interface Callback {
		public void proc(FTPClient client) throws IOException;
	}

	private static final Logger logger = LoggerFactory.getLogger(FTPUtil.class);
	private Callback callback;

	public FTPUtil() {
		// TODO Auto-generated constructor stub
	}

	/**
	 * 로직함수 설정
	 * 
	 * @param callback
	 */
	public void setCallback(Callback callback) {
		// TODO Auto-generated constructor stub
		this.callback = callback;
	}

	/**
	 * FTP 실행
	 * 
	 * @param url
	 * @param id
	 * @param pw
	 * @return
	 */
	public boolean run(String url, String id, String pw) {
		return run(url, id, pw, "euc-kr", null);
	}

	/**
	 * FTP 실행
	 * 
	 * @param url
	 * @param id
	 * @param pw
	 * @param charset
	 * @return
	 */
	public boolean run(String url, String id, String pw, String charset) {
		return run(url, id, pw, charset, null);
	}

	/**
	 * FTP 실행
	 * 
	 * @param url
	 * @param id
	 * @param pw
	 * @param charset
	 * @param workdir
	 * @return
	 */
	public boolean run(String url, String id, String pw, String charset, String workdir) {
		// 접속 정보가 없으면 수행하지않고 return (에러없이 이후로직 수행가능하도록)
		if (StringUtils.isEmpty(url) || StringUtils.isEmpty(id) || StringUtils.isEmpty(pw)) {
			return false;
		}

		FTPClient ftpClient = null;
		try {
			ftpClient = new FTPClient();
			ftpClient.setControlEncoding(charset);
			ftpClient.connect(url);

			int reply = ftpClient.getReplyCode(); // 응답코드가 비정상이면 종료합니다
			if (!FTPReply.isPositiveCompletion(reply)) {
				ftpClient.disconnect();
				throw new EgovBizException("FTP server refused connection.");
			} else {
				logger.debug(ftpClient.getReplyString());

				ftpClient.setSoTimeout(10000); // 현재 커넥션 timeout을 millisecond 값으로 입력합니다
				ftpClient.login(id, pw); // 로그인 유저명과 비밀번호를 입력 합니다
				ftpClient.setFileType(FTP.BINARY_FILE_TYPE);

				// 작업 디렉토리 설정
				if (workdir != null) {
					ftpClient.changeWorkingDirectory(workdir);
				}

				if (this.callback == null) {
					throw new EgovBizException("callback method not defined.");
				}

				// 개발자가 작성한 로직 수행
				this.callback.proc(ftpClient);

				ftpClient.logout();
			}

		} catch (Exception e) {
			logger.error("FTP Reply code = " + ftpClient.getReplyCode());
			e.printStackTrace();
			return false;
		} finally {
			if (ftpClient != null && ftpClient.isConnected()) {
				try {
					ftpClient.disconnect();
				} catch (IOException ioe) {
					ioe.printStackTrace();
				}
			}
		}

		return true;
	}

	/**
	 * 디렉토리/파일 목록 가져오기
	 * 
	 * @param client
	 * @param dir
	 * @return
	 * @throws IOException
	 */
	public List<String> getList(FTPClient client, String dir) throws IOException {
		return getList(client, dir, 0);
	}

	/**
	 * 디렉토리/파일 목록 가져오기
	 * 
	 * @param client
	 * @param dir
	 * @param page
	 * @param perpage
	 * @return
	 * @throws IOException
	 */
	public List<String> getList(FTPClient client, String dir, int perpage) throws IOException {
		List<String> list = new ArrayList<String>();

		if (perpage == 0) {
			FTPFile[] ftpfiles = client.listFiles(dir); // 폴더의 모든 파일을 list 합니다
			if (ftpfiles != null) {
				for (int i = 0; i < ftpfiles.length; i++) {
					FTPFile file = ftpfiles[i];
					logger.debug(file.toString());
					list.add(file.toString());
				}
			}
		} else {
			FTPListParseEngine engine = client.initiateListParsing(dir); // 목록을 나타낼 디렉토리
			while (engine.hasNext()) {
				FTPFile[] ftpfiles = engine.getNext(perpage); // 끊어서 가져온다
				if (ftpfiles != null) {
					for (int i = 0; i < ftpfiles.length; i++) {
						FTPFile file = ftpfiles[i];
						logger.debug(file.toString());
						list.add(file.toString());
					}
				}
			}
		}

		return list;
	}

	/**
	 * 파일 다운로드
	 * 
	 * @param client
	 * @param from_path
	 * @param to_path
	 * @return
	 * @throws IOException
	 */
	public boolean getDownload(FTPClient client, String from_path, String to_path) throws IOException {
		File get_file = new File(to_path);
		OutputStream outputStream = new FileOutputStream(get_file);
		boolean result = client.retrieveFile(from_path, outputStream);
		outputStream.close();

		return result;
	}

	/**
	 * 파일 업로드 (무조건 덮어쓰기)
	 * 
	 * @param client
	 * @param from_path
	 * @param to_path
	 * @return
	 * @throws IOException
	 */
	public String setUpload(FTPClient client, String from_path, String to_path) throws IOException {
		return setUpload(client, from_path, to_path, true, false);
	}

	/**
	 * 파일 업로드 (덮어쓰기 false 인경우 고유파일명으로 무조건 변경)
	 * 
	 * @param client
	 * @param from_path
	 * @param to_path
	 * @param overwrite
	 * @return
	 * @throws IOException
	 */
	public String setUpload(FTPClient client, String from_path, String to_path, boolean overwrite) throws IOException {
		return setUpload(client, from_path, to_path, overwrite, true);
	}

	/**
	 * 파일 업로드
	 * 
	 * @param client
	 * @param from_path
	 * @param to_path
	 * @param overwrite
	 * @param overwriterename
	 * @return
	 * @throws IOException
	 */
	public String setUpload(FTPClient client, String from_path, String to_path, boolean overwrite,
			boolean overwriterename) throws IOException {

		// 파일이 존재 할때 올리면 안되는경우
		if (!overwrite && !overwriterename) {
			List<String> list = getList(client, to_path.substring(0, to_path.lastIndexOf("/")));
			if (list != null) {
				for (int i = 0; i < list.size(); i++) {
					String fn = list.get(i);
					if (fn.contains(to_path.substring(to_path.lastIndexOf("/") + 1))) {
						return null;
					}
				}
			}
		}

		to_path = overwriterename
				? (to_path.substring(0, to_path.lastIndexOf("/") + 1) + Calendar.getInstance().getTimeInMillis() + "_"
						+ to_path.substring(to_path.lastIndexOf("/") + 1))
				: to_path;

		File put_file = new File(from_path);
		InputStream inputStream = new FileInputStream(put_file);
		boolean result = (overwrite || (!overwrite && overwriterename)) ? client.storeFile(to_path, inputStream)
				: client.storeUniqueFile(to_path, inputStream);
		inputStream.close();

		return result ? to_path : "";
	}

	/**
	 * 이름 변경 및 이동
	 * 
	 * @param client
	 * @param from_path
	 * @param to_path
	 * @return
	 * @throws IOException
	 */
	public boolean setRename(FTPClient client, String from_path, String to_path) throws IOException {
		return client.rename(from_path, to_path);
	}

	/**
	 * 파일 삭제
	 * 
	 * @param client
	 * @param path
	 * @return
	 * @throws IOException
	 */
	public boolean setDelete(FTPClient client, String path) throws IOException {
		return client.deleteFile(path);
	}

	/**
	 * 디렉토리 생성
	 * 
	 * @param client
	 * @param path
	 * @return
	 * @throws IOException
	 */
	public boolean setMakeDir(FTPClient client, String path) throws IOException {
		return client.makeDirectory(path);
	}

	/**
	 * 명령어 전송
	 * 
	 * @param client
	 * @param path
	 * @return
	 * @throws IOException
	 */
	public int sendCommand(FTPClient client, FTPCmd cmd, String args) throws IOException {
		return client.sendCommand(cmd, args);
	}
}
