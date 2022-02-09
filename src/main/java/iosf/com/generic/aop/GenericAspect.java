package iosf.com.generic.aop;

import org.aspectj.lang.ProceedingJoinPoint;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.util.StopWatch;

public class GenericAspect {
	private static final Logger LOGGER = LoggerFactory.getLogger(GenericAspect.class);

	public Object controllerAround(ProceedingJoinPoint joinPoint) throws Throwable {
		LOGGER.info("		:: 로직 실행 - {} :: {}", joinPoint.getTarget().getClass().getName(), joinPoint.getSignature().getName().getClass());
		StopWatch stopWatch = new StopWatch();

		try {
			stopWatch.start();
			Object retValue = joinPoint.proceed();
			return retValue;
		} catch (Throwable e) {
			throw e;
		} finally {
			stopWatch.stop();
			LOGGER.info("		:: 로직 종료 [{} ms] - {} :: {}", stopWatch.getTotalTimeMillis(), joinPoint.getTarget().getClass().getName(), joinPoint.getSignature().getName());
		}
	}
}
