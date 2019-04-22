<?php

class Response
{
    const HTTP_VERSION = "HTTP/1.1";

    public static function sendResponse($data)
    {

        if ($data) {
            $code = 200;
            $message = 'OK';
        } else {
            $code = 404;
            $data = array('error' => 'Not Found');
            $message = 'Not Found';
        }


        header(self::HTTP_VERSION . " " . $code . " " . $message);
        header("Content-Type: application/json");
        echo self::encodeJson($data);

    }

    private static function encodeJson($responseData)
    {
        return json_encode($responseData);
    }

}
