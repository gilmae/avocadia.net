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



$router = new Router(array(
    '/' => list_quote,
    '/quote/new' => new_quote,
    '/quote/create' => create_quote,
    '/quote/:id' => view_quote
));

$scratch = Scratch::run($router);


?>

