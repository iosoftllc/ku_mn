package iosf.com.program.attach.service.impl;

import java.io.BufferedInputStream;
import java.io.BufferedOutputStream;
import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.io.PrintWriter;
import java.util.HashMap;

import org.apache.commons.lang3.StringUtils;
import org.springframework.stereotype.Service;
import org.springframework.util.FileCopyUtils;

import egovframework.com.cmm.EgovBrowserUtil;
import egovframework.com.cmm.util.EgovBasicLogger;
import egovframework.com.cmm.util.EgovResourceCloseHelper;
import iosf.com.generic.service.impl.GenericServiceImpl;
import iosf.com.program.attach.service.AttachService;
import iosf.com.program.attach.web.AttachCommand;
import iosf.com.support.util.Functions;
import iosf.com.sys.Configs;

@Service("attachService")
public class AttachServiceImpl extends GenericServiceImpl<AttachMapper, AttachCommand> implements AttachService {
	@Override
	public int delete(AttachCommand cmd) throws Exception {
		// TODO Auto-generated method stub
		if (Configs.IS_DELETE_FILE) {
			try {
				AttachCommand _cmd = new AttachCommand();
				if (cmd.getSeq() != null || cmd.getSeq() <= 0) {
					_cmd.setAttach_idx(cmd.getAttach_idx());
					_cmd.setAttach_seq(cmd.getSeq());
					_cmd = getMapper().getView(_cmd);

					File file = new File(_cmd.getFile_path());
					file.delete();
				} else if (!StringUtils.isEmpty(cmd.getAttach_idx())) {
					_cmd.setAttach_idx(cmd.getAttach_idx());
					_cmd.setList(getMapper().getList(_cmd));

					for (int i = 0; i < _cmd.getList().size(); i++) {
						AttachCommand __cmd = (AttachCommand) _cmd.getList().get(i);
						_cmd.setAttach_seq(__cmd.getAttach_seq());

						File file = new File(__cmd.getFile_path());
						file.delete();
					}
				}
			} catch (Exception err) {
				egovLogger.debug("		:: File Delete Failure : attach_idx = " + cmd.getAttach_idx() + ", attach_seq = " + cmd.getAttach_seq());
			}
		}
		return super.delete(cmd);
	}

	/**
	 * 물리적 다운로드
	 * 
	 * @param cmd
	 * @param req
	 * @param res
	 * @throws Exception
	 */
	public void download(AttachCommand cmd) throws Exception {
		download(cmd, true);
	}

	public void download(AttachCommand cmd, boolean isDB) throws Exception {

		if (isDB) {
			cmd = getMapper().getView(cmd);
		}

		File uFile = new File(cmd.getFile_path());
		long fSize = uFile.length();

		if (fSize > 0) {
			String mimetype = "application/x-msdownload";

			String userAgent = Functions.getReq().getHeader("User-Agent");
			HashMap<String, String> result = EgovBrowserUtil.getBrowser(userAgent);
			if (!EgovBrowserUtil.MSIE.equals(result.get(EgovBrowserUtil.TYPEKEY))) {
				mimetype = "application/x-stuff";
			}

			String contentDisposition = EgovBrowserUtil.getDisposition(cmd.getFile_nm(), userAgent, "UTF-8");

			Functions.getRes().setContentType(mimetype);
			Functions.getRes().setHeader("Content-Disposition", contentDisposition);
			Functions.getRes().setContentLengthLong(fSize);

			BufferedInputStream in = null;
			BufferedOutputStream out = null;

			try {
				in = new BufferedInputStream(new FileInputStream(uFile));
				out = new BufferedOutputStream(Functions.getRes().getOutputStream());

				FileCopyUtils.copy(in, out);
				out.flush();
			} catch (IOException ex) {
				// 다음 Exception 무시 처리
				EgovBasicLogger.ignore("IO Exception", ex);
			} finally {
				EgovResourceCloseHelper.close(in, out);
			}

		} else {
			Functions.getRes().setContentType("application/x-msdownload");

			PrintWriter printwriter = Functions.getRes().getWriter();

			printwriter.println("<html>");
			printwriter.println("<br><br><br><h2>Could not get file name:<br>" + cmd.getFile_nm() + "</h2>");
			printwriter.println("<br><br><br><center><h3><a href='javascript: history.go(-1)'>Back</a></h3></center>");
			printwriter.println("<br><br><br>&copy; webAccess");
			printwriter.println("</html>");

			printwriter.flush();
			printwriter.close();
		}
	}

	@Override
	public void preview(AttachCommand cmd) throws Exception {
		// TODO Auto-generated method stub
		AttachCommand _cmd = new AttachCommand();
		_cmd = getMapper().getView(cmd);

		if (_cmd == null) {
			egovLogger.debug("		:: 파일 정보가 없습니다. : {} / {} / {}", cmd.getAttach_idx(), cmd.getAttach_seq(), cmd.getThumb_size());
			return;
		}

		File file = null;
		FileInputStream fis = null;

		BufferedInputStream in = null;
		ByteArrayOutputStream bStream = null;

		try {
			if (!StringUtils.isEmpty(_cmd.getThumb_size())) {
				file = new File(_cmd.getFile_path() + "_" + _cmd.getThumb_size());
			}
			// 썸네일을 호출했는데 파일이 없다면 원본 이미지를 선택한다
			if (StringUtils.isEmpty(_cmd.getThumb_size()) || !file.exists()) {
				file = new File(_cmd.getFile_path());
			}
			fis = new FileInputStream(file);

			in = new BufferedInputStream(fis);
			bStream = new ByteArrayOutputStream();

			int imgByte;
			while ((imgByte = in.read()) != -1) {
				bStream.write(imgByte);
			}

			String type = "";

			if (!StringUtils.isEmpty(_cmd.getFile_ext())) {
				type = "image/" + _cmd.getFile_ext().toLowerCase();
				if ("jpg".equals(_cmd.getFile_ext().toLowerCase())) {
					type = "image/jpeg";
				} else if ("pdf".equals(_cmd.getFile_ext().toLowerCase())) {
					type = "application/pdf";
				}

			} else {
				egovLogger.debug("		:: Image file type is null.");
			}

			Functions.getRes().setHeader("Content-Type", type);
			Functions.getRes().setContentLength(bStream.size());

			bStream.writeTo(Functions.getRes().getOutputStream());

			Functions.getRes().getOutputStream().flush();
			Functions.getRes().getOutputStream().close();
		} finally {
			EgovResourceCloseHelper.close(bStream, in, fis);
		}
	}
}
