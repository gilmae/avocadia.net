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
    return "List of quotes";
}

function view_quote($route) {
    return "It's a single quote, with id "  . $route['id'];
}

?>