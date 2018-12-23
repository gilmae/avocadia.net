<?php
include("vendor/gilmae/scratch/scratch.php");
include("enbilulu.php");

$CARPE_DIEM_QUOTE = "Whatsoever thy hand findeth to do, do it with thy might; for there is no work, nor device, nor knowledge, nor wisdom, in the grave, whither thou goest";

foreach (glob("config/*.php") as $filename)
{
    include $filename;
}

foreach (glob("app/*.php") as $filename)
{
    include $filename;
}


$e = new Enbilulu();

if (!$e->exists(MICROPUB_STREAM))
{
    $e->create(MICROPUB_STREAM);
}

$router = new Router(
    array(
        '/' => "HomeModule::index",
        '/micropub?q=config' => "MicropubHandler::config",
        '/micropub/media' => "MicropubHandler::media",
        '/micropub' => "MicropubHandler::create",
        '/drafts/:id' => [200, "text/plain", 'draft'] 
    ),
    [
        'X-Carpe-Diem'=> $CARPE_DIEM_QUOTE
    ]
);

$routes = [];


Scratch::run($router);
?>

