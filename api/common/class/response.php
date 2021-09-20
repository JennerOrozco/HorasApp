<?php
class Response
{
    public function response200($Response)
    {
        http_response_code(200);
        echo json_encode($Response);
    }

    public function response404($message)
    {
        http_response_code(404);
        echo json_encode(
            array("status" => false, "message" => $message)
        );
    }

    public function response503($message)
    {
        http_response_code(503);
        echo json_encode(
            array("status" => false, "message" => $message)
        );
    }
}
