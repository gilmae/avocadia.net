<?php

class StreamHandler
{
    public static function get($args) :array
    {
        $stream = MICROPUB_STREAM;

        $point = $args["point"];
        $count = $args["count"] ?? 1;

        $e = new Enbilulu();
        $points = $e->get_records($stream, $point, $count);

        return [200, "application/json", json_encode($points)];
    }

    public static function get_stream_position($args) :array
    {
        $stream = MICROPUB_STREAM;
        $config = Array('type'=>$args['type'], 'starting_point'=>$args['start_from']);

        $e = new Enbilulu();
        $data = (object)Array('point'=>$e->get_stream_point($stream, $config));
        return [200, "application/json", json_encode($data)];
    }
}

?>