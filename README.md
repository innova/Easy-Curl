# README #

## Overview ##
Easy Curl is a simple easy to use wrapper library for PHP curl

## Basic Usage ##
    include_once 'lib/Curl.php'

    // Creating a Curl instance 
    $request = new Curl('http://twitter.com');

    // Execute a GET request
    $request->get();

    // Or execute a POST request
    $post_data = array('fname'=>'Jone','lname'=>'Doe');
    $request->post($post_data);
	
    // Get response of executed request
    $response = $request->response();

    // To get request informations
    $request_info = $request->getInfo();

    // Get HTTP status code 
    $http_status = $request_info['http_code']
    
    // If error occur, to get error message
    $request->getError();

