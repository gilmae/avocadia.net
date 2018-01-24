<?php
 /* 
 * A Quotes collection site
 * 
 * What pages do we need to for this?
 * / => A page to display a list, in chronological order
 * /quote/:id => A detail page to display more information about the quote
 * /quote/new => A form to submit the quote
 * /quote/create => The script that performs the save
 * 
 */


$path_only = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);




function find_route($path)
{
    $routes = array(
        '/^\/$/' => "Whatsoever thy hand findeth to do, do it with thy might; for there is no work, nor device, nor knowledge, nor wisdom, in the grave, whither thou goest",
        '/^\/quote\/new$/' => "It's a quote form",
        '/^\/quote\/create$/' => 'Its a script to save the quote',
        '/^\/quote\/:id$/' => "It's a single quote"
    );

    foreach ($routes as $key => $value)
    {
        $matches;
        $keyAsRegex = translate_route_key_to_regex($key);
        if (preg_match($keyAsRegex, $path, $matches) == 1) {
            $tokens = scan_route_key_for_tokens($key);
            $token_values = array_slice($matches, 1);
            $route_args = array_combine($tokens, $token_values);
            
            return $value;
        }
    }

    return "Nope";
}

function translate_route_key_to_regex($key)
{
    return preg_replace("/(:[^\/$]+)/", "(.+)", $key);
}

function scan_route_key_for_tokens($key)
{
    $matches;
    if (preg_match("/:([^\/$]+)/", $key, $matches) == 1) {
        return array_slice($matches, 1);
    }

}
echo(find_route($path_only));
 


?>

