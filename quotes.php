<?php

function new_quote($route)
{
    $templater = new Templater();
    return [200, 'text/html', $templater->render_template("templates/new.php", array('quotes' => $quotes))];

}

function create_quote($route) 
{ 
    $db = new DB();
    $result = $db->add_quote($_POST['quote']);

    $quote = $db->find_quote(['id'=>$result['id']]);
    $templater = new Templater();
    return [303, 'text/html', '', ['Location' => "/quote/" . $quote[0]->id]];
    
}

function list_quote($route) 
{ 
    $db = new DB();
    $quotes = $db->find_all_quotes();
    $templater = new Templater();
    
    return [200, 'text/html', $templater->render_template("templates/list.php", array('quotes' => $quotes))];
}

function view_quote($route) 
{
    $db = new DB();
    $quote = $db->find_quote(['id'=>$route['id']]);
    $templater = new Templater();

    return [200, 'text/html', $templater->render_template("templates/view.php", ['quote'=>$quote[0]])];
}

?>