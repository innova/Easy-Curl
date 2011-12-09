<?php
/**
 * Innovalabs
 *
 * PHP curl function wrapper calss.
 * 
 * @author	   Ruwan Pathmalal<ruwanpathmalal@gmail.com>	
 * @copyright  2011 Innovalabs 
 * @license    GPL
 * @version    Release: 10.10
 * @since      Class available since Release 10.10
 */

class Curl {
	protected $_headers = array();
	protected $_data = array();
	protected $_url = NULL;
	protected $_options = array(CURLOPT_HEADER=>TRUE,CURLOPT_RETURNTRANSFER=>TRUE,CURLOPT_HEADER=>FALSE);
	protected $_info = array();
	protected $_request = NULL;
	protected $_response = NULL;
	protected $_error = NULL;
	
	/**
	 * Constructor
	 *
	 * @param  string    $url  request url
	 * @return void
	 */
	function __construct($url=NULL){
		if($url){
			$this->_url = $url;
		}
	}
	
	/**
	 * Set curl options
	 *
	 * @param  array    $options  Curl options as array
	 * @return void
	 */
	function setOptions($options=array()){
		$this->_options = array_merge($this->_options,$options);
	}
	
	/**
	 * Set curl option
	 *
	 * @param  string    $name  Name of the option
	 * @param  any  $value Value of option
	 * @return void
	 */
	function setOption($name,$value){
		$this->_options[$name] = $value;
	}
	
	/**
	 * Set headers
	 *
	 * @param  array    $headers  Headers
	 * @return void
	 */
	function setHeaders($headers){
		if (!empty($headers)){
			$this->_headers = $headers;
		}
	}
	
	/**
	 * GET request
	 *
	 * @param  array    $params  parameters for build query string
	 * @param  string   $url url (optional)
	 * @return void
	 */
	function get($params,$url=''){
		$qstr = '';
		if (!empty($url)){
			$this->_url = $url;
		}
		if(!empty($params)){
			$qstr = http_build_query($params);
			$this->_url .= (stripos($this->_url, '?') !== FALSE) ? '&' : '?';
			$this->_url .= $this->_url.$qstr;
		}
		
		$this->request('GET');
	}
	
	/**
	 * POST request
	 *
	 * @param  array    $params  POST data as array
	 * @param  string   $url url (optional)
	 * @return void
	 */
	function post($params,$url=''){
		if (!empty($url)){
			$this->_url = $url;
		}
		
		if (!empty($params)){
			$this->_data = $params;
		}
		
		$this->request('POST');
	}
	
	/**
	 * PUT request
	 *
	 * @param  array    $params Feilds as array
	 * @param  string   $url url (optional)
	 * @return void
	 */
	function put($params,$url=''){
		if (!empty($url)){
			$this->_url = $url;
		}
	
		if (!empty($params)){
			$this->_data = $params;
		}
	
		$this->request('PUT');
	}
	
	/**
	 * DELETE request
	 *
	 * @param  array    $params  Feilds as array
	 * @param  string   $url url (optional)
	 * @return void
	 */
	function delete($params,$url=''){
		if (!empty($url)){
			$this->_url = $url;
		}
	
		if (!empty($params)){
			$this->_data = $params;
		}
	
		$this->request('DELETE');
	}

	/**
	 * Genaric request method that use for other request method
	 *
	 * @param  string    $method  Method type GET/POST/PUT/DELETE
	 * @return void
	 */
	function request($method){
		$this->_request = curl_init($this->_url);
		$this->setRequestMethod($method);
		curl_setopt_array($this->_request, $this->_options);
		$this->setRequestHeaders();
		if(!empty($this->_data)){
			curl_setopt($this->_request, CURLOPT_POSTFIELDS, $this->_data);
		}
		$this->_response = curl_exec($this->_request);
		$this->_info = curl_getinfo($this->_request);
		if (!$this->_response){
			$this->_error = curl_error($this->_request);
		}
		curl_close($this->_request);
	}
	
	/**
	 * Return response of particular request
	 *
	 * @return response
	 */	
	function response(){
		return $this->_response;
	}
	
	/**
	 * Return request infomations
	 *
	 * @return info
	 */
	function getInfo(){
		return $this->_info;
	}	
	
	/**
	 * Return error as string
	 *
	 * @return error
	 */
	function getError(){
		return $this->_error;
	}
	
	/**
	 * Set request headers
	 *
	 * @param  array    $header  request headers
	 * @return void
	 */
	protected function setRequestHeaders() {
		$headers = array();
		foreach ($this->headers as $key => $value) {
			$headers[] = $key.': '.$value;
		}
		
		curl_setopt($this->_request, CURLOPT_HTTPHEADER, $headers);
	}
	
	/**
	 * Set request method
	 *
	 * @param  array    $method  request method
	 * @return void
	 */
	protected function setRequestMethod($method){
		switch (strtoupper($method)) {
			case 'GET':
				curl_setopt($this->_request, CURLOPT_HTTPGET, TRUE);
				break;
			case 'POST':
				curl_setopt($this->_request, CURLOPT_POST, TRUE);
				break;
			default:
				curl_setopt($this->_request, CURLOPT_CUSTOMREQUEST, $method);
		}
	}
}

?>