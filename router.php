<?php

class Router
{
    private $app_routes;
    private $ROUTE_SPEC_REGEX = "/:([^\/$]+)/";

    function __construct($routes)
    {
        $this->app_routes = $routes;
    }

    function call($path)
    {
        foreach ($this->app_routes as $route_spec => $route_proc)
        {
            $matches;
            $routeSpecAsRegex = $this->translate_route_key_to_regex($route_spec);

            if (preg_match($routeSpecAsRegex, $path, $matches) == 1) {
                $tokens = $this->scan_route_key_for_tokens($route_spec);
                $token_values = array_slice($matches, 1);
                
                if ($tokens != null)
                {
                    $route_args = array_combine($tokens, $token_values);
                }
                
                return array(200, array(
                    'Content-type' => 'text/html', 
                    'X-Carpe-Diem'=>"Whatsoever thy hand findeth to do, do it with thy might; for there is no work, nor device, nor knowledge, nor wisdom, in the grave, whither thou goest"), $route_proc($route_args));
            }
        }

        return array(404, array(), 'Not Found');
    }

    function translate_route_key_to_regex($route_spec)
    {
        return "/^" . str_replace("/", "\/", preg_replace($this->ROUTE_SPEC_REGEX, "(.+)", $route_spec)) . "$/";
    }

    function scan_route_key_for_tokens($route_spec)
    {
        $matches;
        if (preg_match($this->ROUTE_SPEC_REGEX, $route_spec, $matches) == 1) 
        {
            return array_slice($matches, 1);
        }

    }
}

?>