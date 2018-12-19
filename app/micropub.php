<?php

class MicropubHandler
{
    public static function create($route)
    {
        $e = new Enbilulu();
        
        $point = $e->put_record("micropub.db", $_POST);

        return [200, "application/json", $point];
    }

    private static function IsAuthorised()
    {

    }
}