<?php

class MicropubHandler
{
    public static function config()
    {
        $c = (object)Array("media-endpoint"=>"http://avocadia.net/micropub/media");
        return [MicropubHandler::OK, "application/json", json_encode($c)];
    }
    
    public static function create($env)
    {
        $authcheck = MicropubHandler::IsAuthorised();

        if ($authcheck != MicropubHandler::OK){
            return [(int)$authcheck, "text/plain", $authcheck];
        }

        if (empty($_POST['h']))
        {
            return [MicropubHandler::BADREQUEST, "text/plain", "Bad Request"];
        }
      
        $e = new Enbilulu();
        $data = $_POST;

        if (isset($data['category']) && !is_array($data['category']))
        {
            $data['category'] = explode(" ", $data['category']);
        }

        if (isset($_FILES['photo']))
        {
            $filename = SV\Utils\Forms\HandleFileUpload($_FILES['photo'], './uploads');
            $data['photo'] = 'http://avocadia.net/' . $filename;
        }

        unset($data['access_token']);

        $point = $e->put_record(MICROPUB_STREAM, $data);

        $filename = sprintf("./drafts/%s.json", $point);

        file_put_contents($filename, json_encode($data));

        return [
            MicropubHandler::CREATED, 
            "text/plain", 
            "", 
            ['Location'=>$filename]
        ];
    }

    public static function media()
    {
        $authcheck = MicropubHandler::IsAuthorised();

        if ($authcheck != MicropubHandler::OK){
            return [(int)$authcheck, "text/plain", $authcheck];
        }

        if (isset($_FILES['file']))
        {
            $filename = SV\Utils\Forms\HandleFileUpload($_FILES['file'], './uploads');
            
        }
        return [MicropubHandler::CREATED, "text/plain", "", ['Location'=>'http://avocadia.net/' . $filename]];
    }

    CONST OK = 200;
    CONST CREATED = 201;
    CONST BADREQUEST = 400;
    CONST UNAUTHORISED = 401;
    CONST FORBIDDEN = 403;

    private static function IsAuthorised()
    {
        if (!REQUIRES_AUTH)
        {
            return true;
        }

        $headers = apache_request_headers();
        // Check token is valid
        $token = $headers['Authorization'];

        $ch = curl_init("https://tokens.indieauth.com/token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array(
             "Content-Type: application/json"
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
        $scope = explode(" ", $response['scope']);

        if(empty($response)){
            
            return MicropubHandler::UNAUTHORISED;
        }elseif($me != "http://avocadia.net/" || !in_array("create",$scope)){
            
            return MicropubHandler::FORBIDDEN;
        }

        return MicropubHandler::OK;
    }

}