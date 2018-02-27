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
    $renderer = new Renderer();
    $r = "list.php";
    return $renderer->render_template($r, array('quotes' => $quotes));
}

function view_quote($route) {
    return "It's a single quote, with id "  . $route['id'];
}

?>