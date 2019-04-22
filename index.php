<?php
/*
 * GET  http://localhost/rest/todo
 * GET  http://localhost/rest/todo/1
 * POST http://localhost/rest/todo?name=SAT&index=10
 * PUT  http://localhost/rest/todo/1?name=SAT
 * DELETE  http://localhost/rest/todo/1 
*/

require('Request.php');

require('Response.php');

$data = Request::getRequest();

Response::sendResponse($data);

