<?php

foreach (glob(dirname(__FILE__) . "/scratch/*.php") as $filename)
{
    include $filename;
}
?>