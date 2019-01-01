<?php

class MicropubHandler
{
    public static function config()
    {
        $c = (object)Array("media-endpoint"=>"http://avocadia.net/micropub/media");
        return [MicropubHandler::OK, "application/json", json_encode($c)];
    }
    
    public static function create($route)
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
        $filename = MicropubHandler::HandleFileUpload('file');
        return [MicropubHandler::CREATED, "text/plain", "", ['Location'=>'http://avocadia.net/' . $filename]];
    }

    CONST OK = 200;
    CONST CREATED = 201;
    CONST BADREQUEST = 400;
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

    private static function HandleFileUpload($uploadedFileName)
    {

        try {
    
            // Undefined | Multiple Files | $_FILES Corruption Attack
            // If this request falls under any of them, treat it invalid.
            if (
                !isset($_FILES[$uploadedFileName]['error']) ||
                is_array($_FILES[$uploadedFileName]['error'])
            ) {
                throw new RuntimeException('Invalid parameters.');
            }
        
            // Check $_FILES[$uploadedFileName]['error'] value.
            switch ($_FILES[$uploadedFileName]['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new RuntimeException('No file sent.');
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new RuntimeException('Exceeded filesize limit.');
                default:
                    throw new RuntimeException('Unknown errors.');
            }
        
            // You should also check filesize here. 
            if ($_FILES[$uploadedFileName]['size'] > 1000000) {
                throw new RuntimeException('Exceeded filesize limit.');
            }
        
            // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
            // Check MIME Type by yourself.
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $finfo->file($_FILES[$uploadedFileName]['tmp_name']);
                
        
            $filename = sprintf('./uploads/%s', uniqid());
            
            // You should name it uniquely.
            // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
            // On this example, obtain safe unique name from its binary data.
            if (!move_uploaded_file(
                $_FILES[$uploadedFileName]['tmp_name'],
                $filename
            )) {
                throw new RuntimeException('Failed to move uploaded file.');
            }
        
            return $filename;
        
        } catch (RuntimeException $e) {
        
            return $e->getMessage();
        
        }
    }
}