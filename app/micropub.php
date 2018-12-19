<?php

class MicropubHandler
{
    public static function create($route)
    {
        $authcheck = MicropubHandler::IsAuthorised();

        if ($authcheck != OK){
            return [(int)$authcheck, "text/plain", $authcheck];
        }

        if (empty($_POST['content']) || empty($_POST['h']))
        {
            return [400, "text/plain", "Bad Request"];
        }

        
        $e = new Enbilulu();
        
        $point = $e->put_record("micropub.db", json_encode($_POST));

        return [202, "text/plain", "ACCEPTED", ['Location'=>'http://avocadia.net/drafts/' . $point]];
    }

    CONST OK = 200;
    CONST UNAUTHORISED = 401;
    CONST FORBIDDEN = 403;

    private static function IsAuthorised()
    {
        $headers = apache_request_headers();
        // Check token is valid
        $token = $headers['Authorization'];
        $ch = curl_init("https://tokens.indieauth.com/token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array(
             "Content-Type: application/x-www-form-urlencoded"
            ,"Authorization: $token"
        ));
        $response = Array();
        parse_str(curl_exec($ch), $response);
        curl_close($ch);
        // Check for scope=post
        // Check for me=https://rhiaro.co.uk
        $me = $response['me'];
        $iss = $response['issued_by'];
        $client = $response['client_id'];
        $scope = $response['scope'];
        if(empty($response)){
            return MicropubHandler::UNAUTHORISED;
        }elseif($me != "http://avocadia.net" || $scope != "post"){
            return MicropubHandler::FORBIDDEN;
        }

        return MicropubHandler::OK;
    }
}