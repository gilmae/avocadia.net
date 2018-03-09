<?php

class HighlightHandler
{
    public static function new($route)
    {
        $templater = new Templater();
        return [200, 'text/html', $templater->render_template("templates/new.php", [])];

    }

    public static function create($route)
    {
        $db = new DB();
        $result = $db->add_highlight($_POST['highlight']);

        $model = $db->find_highlight(['id' => $result['id']]);
        $templater = new Templater();
        return [303, 'text/html', '', ['Location' => "/" . $model[0]->id]];

    }

    public static function list($route)
    {
        $db = new DB();
        $model = $db->find_all_highlights();
        $templater = new Templater();

        return [200, 'text/html', $templater->render_template("templates/list.php", array('model' => $model))];
    }

    public static function view($route)
    {
        $db = new DB();
        $model = $db->find_highlight(['id' => $route['id']]);
        $templater = new Templater();

        return [200, 'text/html', $templater->render_template("templates/view.php", ['model' => $model[0]])];
    }
}
