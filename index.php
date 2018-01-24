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

switch ($path_only){
    case "/":
        echo("Whatsoever thy hand findeth to do, do it with thy might; for there is no work, nor device, nor knowledge, nor wisdom, in the grave, whither thou goest");
        break;
    case "/quote/id":
        echo("It's a single quote");
        break;
    case "/quote/new":
        echo("Its a form");
        break;
    case "/quote/create":
        echo("Saving yer quote");
        break;
}
 


?>

