<?php

class StreamHandler
{
    public static function Get() :array
    {
        $stream = MICROPUB_STREAM;
        $point = $_GET["point"];
        $count = $_GET["count"] ?? 1;

        $e = new Enbilulu();
        $points = $e->get_records($stream, $point, $count);

        return [200, "application/json", json_encode($points)];
    }
}

?>