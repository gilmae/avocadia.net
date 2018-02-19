<?php

class Application
{
    private $app_routes;

    function __construct($routes)
    {
        $this->app_routes = $routes;
    }

    function call($path)
    {
        foreach ($this->app_routes as $key => $value)
        {
            $matches;
            $keyAsRegex = $this->translate_route_key_to_regex($key);

            if (preg_match($keyAsRegex, $path, $matches) == 1) {
                $tokens = $this->scan_route_key_for_tokens($key);
                $token_values = array_slice($matches, 1);
                
                if ($tokens != null)
                {
                    $route_args = array_combine($tokens, $token_values);
                }
                
                return array(200, array('Content-type' => 'text/html', 'X-Carpe-Diem'=>"Whatsoever thy hand findeth to do, do it with thy might; for there is no work, nor device, nor knowledge, nor wisdom, in the grave, whither thou goest"), $value($route_args));
            }
        }

        return array(404, array(), 'Not Found');
    }

    function translate_route_key_to_regex($key)
    {
        return "/^" . str_replace("/", "\/", preg_replace("/(:[^\/$]+)/", "(.+)", $key)) . "$/";
    }

    function scan_route_key_for_tokens($key)
    {
        $matches;
        if (preg_match("/:([^\/$]+)/", $key, $matches) == 1) 
        {
            return array_slice($matches, 1);
        }

    }
}

?>