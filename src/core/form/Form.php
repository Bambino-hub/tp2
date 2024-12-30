<?php

namespace App\core\form;

use App\core\form\Field;

class Form
{

    public static function begin($action = '', $method = 'post')
    {
        echo sprintf('<form action= "%s" method="%s">', $action, $method);
        return new Form();
    }

    public static function end()
    {
        echo '</form>';
    }

    /**
     * cette fonction fait appel a la classe field lui passe le model
     * le nom du champ (par exemple si le champ est firstname on envoie firstname)
     * le type a utilisé c'est à dire (type = 'text')
     *
     * @param [type] $model
     * @param string $name
     * @param string $type
     * @return void
     */
    public function field($model, string $name,  string $type)
    {
        return new Field($model, $name, $type);
    }
}
