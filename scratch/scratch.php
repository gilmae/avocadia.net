<?php

foreach (glob(dirname(__FILE__) . "/app/*.php") as $filename)
{
    include $filename;
}
?>