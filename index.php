<?php
include("scratch/scratch.php");

foreach (glob("config/*.php") as $filename)
{
    include $filename;
}

include("quotes.php");

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

$router = new Router(array(
    '/' => list_quote,
    '/quote/new' => new_quote,
    '/quote/create' => create_quote,
    '/quote/:id' => view_quote
));

$result = $router->call($path_only);

/*
* Following should be pulled into a renderer class
*/
http_response_code($result[0]);
foreach ($result[1] as $key => $value)
{
    header($key . ": " . $value);
}

if (!is_array($result[2])) 
{
    $result[2] = array($result[2]);
}

foreach ($result[2] as $body)
{
    echo($body);
}


?>

