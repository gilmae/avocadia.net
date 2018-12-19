<?php
    class HomeModule
    {
        public static function index($route)
        {
            $t = new Templater();
            $page = $t->render_template("app/home.html");

            return [200, "text/html", $page];
        }
        
    }
?>