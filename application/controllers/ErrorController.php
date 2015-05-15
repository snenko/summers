<?php

class ErrorController extends Zend_Controller_Action
{

    public function errorAction()
    {
		$errors = $this->_getParam('error_handler');
		switch ($errors->type) {
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:

				// 404 error -- controller or action not found
				$this->getResponse()->setHttpResponseCode(404);
				$this->view->title = 'Page Not Found';
				$this->view->message = 'The requested page could not be found.';
				break;

			default:
				// application error
				$this->getResponse()->setHttpResponseCode(500);
				$this->view->title = 'Internal Server Error';
				$this->view->message = 'Due to an application error, the requested page could not be displayed.';
				break;
		}

		$this->view->exception = $errors->exception;
		$this->view->request   = $errors->request;

		// initialize logging engine
		$logger = new Zend_Log();

		// add XML writer
		$config = $this->getInvokeArg('bootstrap')->getOption('logs');
		$xmlWriter = new Zend_Log_Writer_Stream($config['logPath'] . '/error.log.xml');
		$logger->addWriter($xmlWriter);
		$formatter = new Zend_Log_Formatter_Xml();
		$xmlWriter->setFormatter($formatter);

		// add Doctrine writer
		$columnMap = array(
			'message' => 'LogMessage',
			'priorityName' => 'LogLevel',
			'timestamp' => 'LogTime',
			'stacktrace' => 'Stack',
			'request' => 'Request',
		);
//		$dbWriter = new Summers_Log_Writer_Doctrine('Snenkonotes_Model_Log', $columnMap);
//		$logger->addWriter($dbWriter);

		// add Firebug writer
		$fbWriter = new Zend_Log_Writer_Firebug();
		$logger->addWriter($fbWriter);

		// add additional data to log message - stack trace and request parameters
		$logger->setEventItem('stacktrace', $errors->exception->getTraceAsString());
		$logger->setEventItem('request', Zend_Debug::dump($errors->request->getParams()));

		// log exception to writer
		$logger->log($errors->exception->getMessage(), Zend_Log::ERR);
    }

    public function accessDeniedAction()
    {
    }

    public function deniedAction()
    {
        $params = $this->getRequest()->getParams();
        $this->view->title = 'Access denied!';
        $this->view->message = $params['message'];

        $stack_trace =  $this->_getFullErrorMessage();

        // 403 error -- access denied
        $this->getResponse()->setHttpResponseCode(403);
        $this->view->responseCode = 403;
        $this->view->role = $params['role'];
        $this->view->resource = $params['resource'];
        $this->view->stack_trace = $stack_trace;

        // add Firebug writer
        $logger = new Zend_Log();
        $config = $this->getInvokeArg('bootstrap')->getOption('logs');
        $xmlWriter = new Zend_Log_Writer_Stream($config['logPath'] . '/error.log.xml');
        $logger->addWriter($xmlWriter);

        // log exception to writer
        $logger->log($stack_trace, Zend_Log::ALERT);
    }

    protected function _getFullErrorMessage($error = null)
    {
//        if (!DEBUG_ENABLE) {
//            return '';
//        }

        $message = '';

        if (!empty($_SERVER['SERVER_ADDR'])) {
            $message .= "Server IP: " . $_SERVER['SERVER_ADDR'] . "\n";
        }

        if (!empty($_SERVER['HTTP_USER_AGENT'])) {
            $message .= "User agent: " . $_SERVER['HTTP_USER_AGENT'] . "\n";
        }

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $message .= "Request type: " . $_SERVER['HTTP_X_REQUESTED_WITH'] . "\n";
        }

        if (!empty($_SERVER['HTTP_REFERER'])) {
            $message .= "Referer: " . $_SERVER['HTTP_REFERER'] . "\n";
        }

        $message .= "Server time: " . date("Y-m-d H:i:s") . "\n";

        if (null !== $error) {
            $message .= "RequestURI: " . urldecode($error->request->getRequestUri()) . "\n";
            $message .= "Exception type: " . get_class($error->exception) . "\n";
            $message .= "Message: " . $error->exception->getMessage() . "\n\n";
            $message .= "Trace:\n" . $error->exception->getTraceAsString() . "\n\n";
            $message .= "Request data: " . var_export($error->request->getParams(), true) . "\n\n";
        }

        if (!empty($_SESSION)) {
            $it = $_SESSION;

            $message .= "Session data:\n\n";
            foreach ($it as $key => $value) {
                $message .= $key . ": " . var_export($value, true) . "\n";
            }
            $message .= "\n";
        }

        if (!empty($_COOKIES)) {
            $message .= "Cookie data:\n\n";
            foreach ($_COOKIES as $key => $value) {
                $message .= $key . ": " . var_export($value, true) . "\n";
            }
            $message .= "\n";
        }

        return $message;
    }

}





