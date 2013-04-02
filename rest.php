<?php
include('/usr/local/lib/tm/ChromePhp.php');
ChromePhp::log("in rest.php");
class RestUtils
{
	public static function processRequest()
	{
		// get our verb 
		$request_method = strtolower($_SERVER['REQUEST_METHOD']);
		$request_time = $_SERVER['REQUEST_TIME'];
		$headers = apache_request_headers();
		$url = $_SERVER['REQUEST_URI'];
		$urlarr = parse_url($url);
		$pathstr=substr($urlarr["path"],1);
		$patharr= explode("/", $pathstr);
		$return_obj		= new RestRequest();
		// we'll store our data here
		$data			= array();
		
		$return_obj->setPathArr($patharr);
		$return_obj->setHttpHeaders($headers);
		$return_obj->setTimeStamp($request_time);
		switch ($request_method)
		{
			// gets are easy...
			case 'get':
				$data = $_GET;
				//echo("here comes datastring \n\n");
				//print_r($data);
				break;
			// so are posts
			case 'post':
				$data = $_POST;
				break;
			// here's the tricky bit...
			case 'put':
				// basically, we read a string fr om PHP's special input location,
				// and then parse it out into an array via parse_str... per the PHP docs:
				// Parses str  as if it were the query string passed via a URL and sets
				// variables in the current scope.
				//assumes JSON put starting like {"data": {"the": 123} }
				$thefile=file_get_contents("php://input");
				//echo("On server in processRequest() of rest.php. data is gotten from file_get_contents()\n");
				//echo $thefile;
				$json = $thefile;
				$return_obj->setJson($json);
				//the true parameter forces it to decode to array instead of object
				//$thearr = (array) json_decode($thefile) only converts the outer object
				$data = json_decode($thefile,true);	
				//print_r($data);
				break;
		}
		$return_obj->setData($data);
		// store the method
		$return_obj->setMethod($request_method);
		return $return_obj;
	}
	public static function sendResponse($status = 200, $body = '', $content_type = 'text/html')
	{
		$status_header = 'HTTP/1.1 ' . $status . ' ' . RestUtils::getStatusCodeMessage($status);
		// set the status
		header($status_header);
		// set the content type
		header('Content-type: ' . $content_type);

		// pages with body are easy
		if($body != '')
		{
			// send the body
			echo $body;
			exit;
		}
		// we need to create the body if none is passed
		else
		{
			// create some body messages
			$message = '';

			// this is purely optional, but makes the pages a little nicer to read
			// for your users.  Since you won't likely send a lot of different status codes,
			// this also shouldn't be too ponderous to maintain
			switch($status)
			{
				case 401:
					$message = 'You must be authorized to view this page.';
					break;
				case 404:
					$message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
					break;
				case 500:
					$message = 'The server encountered an error processing your request.';
					break;
				case 501:
					$message = 'The requested method is not implemented.';
					break;
			}

			// servers don't always have a signature turned on (this is an apache directive "ServerSignature On")
			$signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];

			// this should be templatized in a real-world solution
			$body = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
						<html>
							<head>
								<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
								<title>' . $status . ' ' . RestUtils::getStatusCodeMessage($status) . '</title>
							</head>
							<body>
								<h1>' . RestUtils::getStatusCodeMessage($status) . '</h1>
								<p>' . $message . '</p>
								<hr />
								<address>' . $signature . '</address>
							</body>
						</html>';

			echo $body;
			exit;
		}
	}

	public static function getStatusCodeMessage($status)
	{
		// these could be stored in a .ini file and loaded
		// via parse_ini_file()... however, this will suffice
		// for an example
		$codes = Array(
		    100 => 'Continue',
		    101 => 'Switching Protocols',
		    200 => 'OK',
		    201 => 'Created',
		    202 => 'Accepted',
		    203 => 'Non-Authoritative Information',
		    204 => 'No Content',
		    205 => 'Reset Content',
		    206 => 'Partial Content',
		    300 => 'Multiple Choices',
		    301 => 'Moved Permanently',
		    302 => 'Found',
		    303 => 'See Other',
		    304 => 'Not Modified',
		    305 => 'Use Proxy',
		    306 => '(Unused)',
		    307 => 'Temporary Redirect',
		    400 => 'Bad Request',
		    401 => 'Unauthorized',
		    402 => 'Payment Required',
		    403 => 'Forbidden',
		    404 => 'Not Found',
		    405 => 'Method Not Allowed',
		    406 => 'Not Acceptable',
		    407 => 'Proxy Authentication Required',
		    408 => 'Request Timeout',
		    409 => 'Conflict',
		    410 => 'Gone',
		    411 => 'Length Required',
		    412 => 'Precondition Failed',
		    413 => 'Request Entity Too Large',
		    414 => 'Request-URI Too Long',
		    415 => 'Unsupported Media Type',
		    416 => 'Requested Range Not Satisfiable',
		    417 => 'Expectation Failed',
		    500 => 'Internal Server Error',
		    501 => 'Not Implemented',
		    502 => 'Bad Gateway',
		    503 => 'Service Unavailable',
		    504 => 'Gateway Timeout',
		    505 => 'HTTP Version Not Supported'
		);

		return (isset($codes[$status])) ? $codes[$status] : '';
	}
}

class RestRequest
{
	private $request_vars;
	private $data;
	private $http_accept;
	private $method;
	private $header;
	private $patharr;
	private $json = '{"data": 0}';
	private $time;

	public function __construct()
	{
		$this->request_vars		= array();
		$this->data				= '';
		$this->http_accept		= $_SERVER['HTTP_ACCEPT'];
		$this->method			= 'get';
	}
	public function setTimeStamp($request_time){
		$this->time = $request_time;
	}		
	public function setPathArr($path_arr){
		$this->patharr = $path_arr;
	}	
	public function setHttpHeaders($http_header){
		$this->header = $http_header;
	}	
	public function setJson($json){
		$this->json = $json;
	}
	public function setData($data)
	{
		$this->data = $data;
	}
	public function setMethod($method)
	{
		$this->method = $method;
	}
	public function getData()
	{
		return $this->data;
	}
	public function getMethod()
	{
		return $this->method;
	}
	public function getHttpAccept()
	{
		return $this->http_accept;
	}	
	public function getJson(){
		return $this->json;
	}
	public function getHttpHeaders(){
		return $this->header;
	}	
	public function getPathArr(){
		return $this->patharr;
	}		
	public function getTimeStamp(){
		return $this->time;
	}			
}

?>