<?php

if (!function_exists('register_model_type')) {
    function register_model_type($model_type, $model_attributes = [])
    {
        return app('model_type')->registerModelType($model_type, $model_attributes);
    }
}

if (!function_exists('model_types')) {
    function model_types()
    {
        return app('model_type')->getModelTypes();
    }
}
