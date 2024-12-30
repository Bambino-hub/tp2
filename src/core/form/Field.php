<?php

namespace App\core\form;

use App\models\Model;

class Field
{
    public Model $model;
    protected string $name;
    protected string $type;
    public function __construct(Model $model, string $name, string $type)
    {
        $this->name = $name;
        $this->type = $type;
        $this->model = $model;
    }

    /**
     * cette fonction nous permet creer notre formulaire
     * cette fonction nous permet aussi de trnasformer une classe en une chaine de caractère
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '
         <div class="form-group">
        <label for="%s" >%s</label>
        <input type="%s" name="%s" id="%s" value="%s"  class="form-control%s">
        <div class="invalid-feedback">
         %s
       </div>
        </div>
        ',

            $this->name,
            $this->model->attributeLabels()[$this->name],
            $this->type,
            $this->name,
            $this->name,
            $this->model->{$this->name},
            $this->model->hasError($this->name) ? ' is-invalid' : '',
            $this->model->getFirstError($this->name)

        );
    }
}
