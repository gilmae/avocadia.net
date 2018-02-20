<?php


function new_quote($route)
{
    return "It's a quote form";
}

function create_quote($route) 
{ 
    return 'Its a script to save the quote';
}

function list_quote($route) 
{ 
    $db = new DB();
    $quotes = $db->find_all_quotes();

    $r = "";
    foreach($quotes as $quote)
    {
        $r = $r . "<p>" . $quote->quote . "</p>";
    }
    return $r;
}

function view_quote($route) {
    return "It's a single quote, with id "  . $route['id'];
}

?>