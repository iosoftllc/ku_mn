package iosf.com.program.attach.util;

import java.awt.Image;
import java.awt.image.BufferedImage;
import java.awt.image.PixelGrabber;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Iterator;
import java.util.List;
import java.util.Map;
import java.util.Map.Entry;
import java.util.UUID;

import javax.annotation.Resource;
import javax.imageio.ImageIO;
import javax.swing.ImageIcon;

import org.apache.commons.lang3.StringUtils;
import org.springframework.dao.DataAccessException;
import org.springframework.stereotype.Component;
import org.springframework.util.FileCopyUtils;
import org.springframework.web.multipart.MultipartFile;

import egovframework.com.cmm.EgovWebUtil;
import egovframework.com.cmm.service.EgovProperties;
import egovframework.rte.fdl.cmmn.exception.EgovBizException;
import iosf.com.program.attach.service.AttachService;
import iosf.com.program.attach.web.AttachCommand;
import iosf.com.support.util.Functions;
import iosf.com.sys.Configs;

@Component("attachUtil")
public class AttachUtil {

	public static final int BUFF_SIZE = 2048;

	@Resource(name = "attachService")
	private AttachService attachService;

	/***
	 * 파일 업로드 (URL접근 가능 파일)
	 * 
	 * @param files
	 * @param key
	 * @param cmd
	 * @param req
	 * @param res
	 * @return
	 * @throws Exception
	 */
	public AttachCommand upload_www(Map<String, MultipartFile> files) throws DataAccessException, Exception {
		return upload_www(files, "files", false);
	}

	public AttachCommand upload_www(Map<String, MultipartFile> files, String key, boolean bDb) throws DataAccessException, Exception {
		return upload_www(files, key, bDb, null);
	}

	public AttachCommand upload_www(Map<String, MultipartFile> files, String key, boolean bDb, String idx) throws DataAccessException, Exception {

		AttachCommand attachCommand = new AttachCommand();

		if (files != null && files.size() > 0) {

			String sep = System.getProperty("file.separator");
			String originalDir = Configs.ROOT_PATH + sep + Configs.WWW_PATH;
			List<String> list = new ArrayList<String>();

			Iterator<Entry<String, MultipartFile>> itr = files.entrySet().iterator();

			while (itr.hasNext()) {
				Entry<String, MultipartFile> entry = itr.next();

				MultipartFile file = entry.getValue();
				String orginFileName = file.getOriginalFilename();

				String[] ext = EgovProperties.getProperty("Globals.fileUpload.Extensions").split(".");
				for (int i = 0; i < ext.length; i++) {
					if (orginFileName.contains("." + ext[i])) {
						throw new EgovBizException(orginFileName + " 파일은 허용된 파일 타입이 아닙니다.");
					}
				}
			}

			itr = files.entrySet().iterator();
			int num = 0;

			while (itr.hasNext()) {
				UUID randomUUID = UUID.randomUUID();
				idx = StringUtils.isEmpty(idx) ? randomUUID.toString() : idx;
				Entry<String, MultipartFile> entry = itr.next();
				MultipartFile multipartFile = entry.getValue();
				long file_size = multipartFile.getSize();
				String content_type = multipartFile.getContentType();

				// input name 과 맞는 업로드 파일만
				if (key.equals(entry.getValue())) {
					continue;
				}

				if (file_size > 0 && (content_type.contains("image") || content_type.contains("video"))) {

					// 경로 생성
					File dirPath = new File(EgovWebUtil.filePathBlackList(originalDir));
					if (!dirPath.exists()) {
						dirPath.mkdirs();
					}

					// 파일 저장
					String file_nm = multipartFile.getOriginalFilename();
					String ext = file_nm.contains(".") ? file_nm.split("\\.")[file_nm.split("\\.").length - 1] : "";
					String save_path = originalDir + sep + idx + "." + ext;

					File uploadedFile = new File(save_path);
					FileCopyUtils.copy(multipartFile.getInputStream(), new FileOutputStream(uploadedFile));

					list.add(Configs.WWW_PATH.replaceAll("/", "") + idx + "." + ext);

					// DB 저장
					if (bDb) {
						attachCommand.setAttach_idx(idx);
						attachCommand.setFile_nm(multipartFile.getOriginalFilename());
						attachCommand.setFile_size(file_size);
						attachCommand.setFile_type(content_type);
						attachCommand.setFile_path(save_path);
						attachCommand.setFile_ext(ext);
						attachCommand.setOrd_no(++num);

						attachService.insert(attachCommand);
					}
				}
			}

			attachCommand.setList(list);
		}

		return attachCommand;
	}

	/***
	 * 파일 업로드
	 * 
	 * @param req
	 * @param res
	 * @param files
	 * @param key
	 * @param attach_idx
	 * @param cmd
	 * @return
	 * @throws Exception
	 */

	public String upload(List<MultipartFile> files) throws DataAccessException, Exception {
		return upload(files, null, null, null, null, null);
	}

	public String upload(List<MultipartFile> files, String attach_idx) throws DataAccessException, Exception {
		return upload(files, attach_idx, null, null, null, null);
	}

	public String upload(List<MultipartFile> files, String attach_idx, String thumb_yn, String thumb_size) throws DataAccessException, Exception {
		return upload(files, attach_idx, thumb_yn, thumb_size, null, null);
	}

	public String upload(List<MultipartFile> files, String attach_idx, String thumb_yn, String thumb_size, String cp_dir) throws DataAccessException, Exception {
		return upload(files, attach_idx, thumb_yn, thumb_size, cp_dir, null);
	}

	public String upload(List<MultipartFile> files, String attach_idx, String thumb_yn, String thumb_size, String cp_dir, String file_type) throws DataAccessException, Exception {

		AttachCommand attachCommand = new AttachCommand();

		// ATTACH_IDX 구하기
		if (StringUtils.isEmpty(attach_idx)) {
			UUID randomUUID = UUID.randomUUID();
			attach_idx = randomUUID.toString();
		}
		attachCommand.setAttach_idx(attach_idx);

		if (files != null && files.size() > 0) {

			String sep = System.getProperty("file.separator");
			String originalDir = Configs.SAVE_PATH + sep + Calendar.getInstance().get(Calendar.YEAR) + sep + (Calendar.getInstance().get(Calendar.MONTH) + 1) + sep + Calendar.getInstance().get(Calendar.DATE) + sep + attach_idx;

			Iterator<MultipartFile> itr = files.iterator();

			while (itr.hasNext()) {
				MultipartFile file = itr.next();
				String orginFileName = file.getOriginalFilename();

				String[] ext = EgovProperties.getProperty("Globals.fileUpload.Extensions").split(".");
				for (int i = 0; i < ext.length; i++) {
					if (orginFileName.contains("." + ext[i])) {
						throw new EgovBizException(orginFileName + " 파일은 허용된 파일 타입이 아닙니다.");
					}
				}
			}

			itr = files.iterator();
			int num = 0;
			while (itr.hasNext()) {

				UUID randomUUID = UUID.randomUUID();
				MultipartFile multipartFile = itr.next();
				long file_size = multipartFile.getSize();
				String content_type = multipartFile.getContentType();

				if (file_size > 0 && (StringUtils.isEmpty(file_type) || (!StringUtils.isEmpty(file_type) && content_type.contains(file_type)))) {

					// 경로 생성
					File dirPath = new File(EgovWebUtil.filePathBlackList(originalDir));
					if (!dirPath.exists()) {
						dirPath.mkdirs();
					}

					// 파일 저장
					String file_nm = multipartFile.getOriginalFilename();
					String ext = file_nm.contains(".") ? file_nm.split("\\.")[file_nm.split("\\.").length - 1] : "";
					String save_path = originalDir + sep + randomUUID.toString();

					File uploadedFile = new File(save_path);
					FileCopyUtils.copy(multipartFile.getInputStream(), new FileOutputStream(uploadedFile));

					// 파일 복사
					if (!StringUtils.isEmpty(cp_dir)) {
						copyFile(save_path, cp_dir + randomUUID.toString());
					}

					try {
						// 모바일에서 찍은 JPG 파일인경우 자동으로 돌아간다. 그래서 다시 돌려줘야함
						if (ext.equalsIgnoreCase("jpg") || ext.equalsIgnoreCase("jpeg")) {
							BufferedImage img = Functions.correctOrientation(save_path);
							if (img != null) {
								ImageIO.write(img, "jpg", uploadedFile);
								// 용량도 대폭 줄어든다.
								file_size = uploadedFile.length();
							}
						}
					} catch (Exception e) {
						e.printStackTrace();
					}

					// DB 저장
					attachCommand.setFile_nm(multipartFile.getOriginalFilename());
					attachCommand.setFile_size(file_size);
					attachCommand.setFile_type(content_type);
					attachCommand.setFile_path(save_path);
					attachCommand.setFile_ext(ext);
					attachCommand.setOrd_no(++num);

					attachService.insert(attachCommand);

					// 이미지인경우 썸네일 파일을 만든다. (웹서버의 경로에 atchFileId.jpg 같은 파일로 생성
					try {
						if (ext.equalsIgnoreCase("jpg") || ext.equalsIgnoreCase("gif") || ext.equalsIgnoreCase("jpeg") || ext.equalsIgnoreCase("png")) {
							if ("Y".equals(StringUtils.defaultIfEmpty(thumb_yn, "N")) && !StringUtils.isEmpty(thumb_size)) {
								// 썸네일 크기는 여러개인경우 ; 로 append한다. 최소 사이즈로 한 후 비율로 계산
								String[] size = thumb_size.split(";");
								for (int i = 0; i < size.length; i++) {
									createThumbnail(save_path, save_path + "_" + size[i], Integer.parseInt(size[i]));
								}
							}
						}
					} catch (Exception e) {
						e.printStackTrace();
					}
				}
			}
		}
		return attach_idx;
	}

	private int copyFile(String s, String t) throws Exception {
		File f1 = new File(s);
		int i = 0;

		if (f1.exists()) {
			FileInputStream fin = new FileInputStream(s);
			FileOutputStream fout = new FileOutputStream(t);
			byte buffer[] = new byte[1024];
			int j;
			while ((j = fin.read(buffer)) >= 0)
				fout.write(buffer, 0, j);

			fout.close();
			fin.close();
		} else
			i = 1;
		return i;
	}

	public boolean createThumbnail(String loadFile, String saveFile, int maxDim) throws IOException, InterruptedException {
		String imgFormat = "jpg"; // 새 이미지 포맷. jpg, gif 등
		String mainPosition = "W"; // W:넓이중심, H:높이중심, X:설정한 수치로(비율무시)
		int imageWidth;
		int imageHeight;
		double ratio;
		int w;
		int h;

		File save = new File(saveFile.replaceAll("/", "\\" + File.separator));
		FileInputStream fis = new FileInputStream(loadFile.replaceAll("/", "\\" + File.separator));
		Image srcImg = null;
		if (saveFile.toLowerCase().contains(".bmp") || saveFile.toLowerCase().contains(".png") || saveFile.toLowerCase().equals(".gif")) {
			srcImg = ImageIO.read(fis);
		} else {
			// BMP가 아닌 경우 ImageIcon을 활용해서 Image 생성
			// 이렇게 하는 이유는 getScaledInstance를 통해 구한 이미지를
			// PixelGrabber.grabPixels로 리사이즈 할때
			// 빠르게 처리하기 위함이다.
			srcImg = new ImageIcon(loadFile).getImage();
		}

		// 원본 이미지 사이즈 가져오기
		imageWidth = srcImg.getWidth(null);
		imageHeight = srcImg.getHeight(null);

		// 높이 사이즈가 너비보다 클때 높이 기준으로 처리
		if (imageHeight > imageWidth) {
			mainPosition = "H";
		}

		if (mainPosition.equals("W")) { // 넓이기준

			ratio = (double) maxDim / (double) imageWidth;
			w = (int) (imageWidth * ratio);
			h = (int) (imageHeight * ratio);

		} else if (mainPosition.equals("H")) { // 높이기준

			ratio = (double) maxDim / (double) imageHeight;
			w = (int) (imageWidth * ratio);
			h = (int) (imageHeight * ratio);

		} else { // 설정값 (비율무시)

			w = maxDim;
			h = maxDim;
		}
		int pixels[] = new int[w * h];

		// 이미지 리사이즈
		// Image.SCALE_DEFAULT : 기본 이미지 스케일링 알고리즘 사용
		// Image.SCALE_FAST : 이미지 부드러움보다 속도 우선
		// Image.SCALE_REPLICATE : ReplicateScaleFilter 클래스로 구체화 된 이미지 크기 조절 알고리즘
		// Image.SCALE_SMOOTH : 속도보다 이미지 부드러움을 우선
		// Image.SCALE_AREA_AVERAGING : 평균 알고리즘 사용
		Image resizeImage = srcImg.getScaledInstance(w, h, Image.SCALE_SMOOTH);

		PixelGrabber pg = new PixelGrabber(resizeImage, 0, 0, w, h, pixels, 0, w);
		pg.grabPixels();

		BufferedImage newImage = new BufferedImage(w, h, BufferedImage.TYPE_INT_RGB);
		newImage.setRGB(0, 0, w, h, pixels, 0, w);

		return ImageIO.write(newImage, imgFormat, save);
	}

	public void download(AttachCommand cmd) throws Exception {
		attachService.download(cmd, false);
	}
}
