<?php

namespace Bws\Core\Classes;

use Bws\Core\Exceptions\NoModelTypeException;

class ModelType
{
    protected $model_types = [];

    /**
     * @return array
     */
    public function getModelTypes()
    {
        return $this->model_types;
    }

    public function registerModelType($model_type, $model_attributes = [])
    {
        if (!$model_type) {
            throw new NoModelTypeException();
        }

        $default_attributes = [
            'name' => '',
            'singular_name' => '',
            'plural_name' => '',
            'show_in_admin_menu' => true,
            'parent_admin_menu' => 'mn_general_sections',
            'menu_position' => 0,
            'menu_icon' => 'feather icon-box',
            'actions' => []
        ];

        $model_attributes = array_merge($default_attributes, $model_attributes);
        $this->model_types[$model_type] = $model_attributes;

        return $this;
    }
}
