<?php
    class HomeModule
    {
        public static function index($env)
        {
            $t = new Scratch\Templater();
            $page = $t->render_template("app/home.html");

            return [200, "text/html", $page];
        }
        
    }
?>