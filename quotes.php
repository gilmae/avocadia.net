<?php

function new_quote($route)
{
    $templater = new Templater();
    return $templater->render_template("new.php", array('quotes' => $quotes));

}

function create_quote($route) 
{ 
    $db = new DB();
    $result = $db->add_quote($_POST['quote']);
    
    return "It's a single quote, with id "  . $result['id'];
}

function list_quote($route) 
{ 
    $db = new DB();
    $quotes = $db->find_all_quotes();
    $templater = new Templater();
    
    return $templater->render_template("list.php", array('quotes' => $quotes));
}

function view_quote($route) 
{
    return "It's a single quote, with id "  . $route['id'];
}

?>