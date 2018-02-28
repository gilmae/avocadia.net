<?php

foreach (glob(dirname(__FILE__) . "/app/*.php") as $filename)
{
    include $filename;
}

class Scratch
{

    function run($app_results)
    {
        if (!is_array($app_results))
        {
            throw new Exception("Invalid App Results, expecting array: [Status, Headers, Body]");
        }

        if (count($app_results) != 3)
        {
            throw new Exception("Invalid App Results, expecting array: [Status, Headers, Body]");          
        }

        $status = $app_results[0];
        $headers = $app_results[1];
        $body = $app_results[2];

        http_response_code($status);

        if (is_array($headers))
        {
            foreach ($headers as $key => $value)
            {
                header($key . ": " . $value);
            }
        }

        if (!is_array($body)) 
        {
            $body = array($body);
        }

        foreach ($body as $body_item)
        {
            echo($body_item);
        }
    }

    
}
?>