<?php

namespace Bws\Shortcode\Http\Controllers;

use Bws\Core\Facades\Fields\ActionField;
use Bws\Core\Facades\Fields\FieldsGroup;
use Bws\Core\Facades\Fields\LabelField;
use Bws\Core\Facades\Fields\TextField;
use Bws\Core\Facades\Form;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ShortcodeController extends Controller
{
    public function getShortcodeForm(Request $request)
    {
        $shortcode = $request->input('shortcode', null);
        $result = $request->input('result', null);

        $form_fields = [
            TextField::make('_shortcode', 'hidden')->setValue($shortcode),
            TextField::make('_result', 'hidden')->setValue($result)
        ];

        $html = '';
        if ($shortcode) {
            $registered = app('shortcode.compiler')->getRegistered();
            if (isset($registered[$shortcode]) && $registered[$shortcode]) {
                $params = isset($registered[$shortcode]['params']) ? $registered[$shortcode]['params'] : [];
                foreach ($params as $param_name => $param) {
                    $options = isset($param['options']) && $param['options'] ? $param['options'] : [];
                    $value = isset($param['value']) && $param['value'] ? $param['value'] : '';
                    $label = isset($param['label']) && $param['label'] ? $param['label'] : '';
                    $fieldsGroup = [];
                    if ($label) {
                        $fieldsGroup[] = LabelField::make($param_name)->label($label)->className('form-label');
                    }
                    switch ($param['type']) {
                        default:
                            $fieldsGroup[] = TextField::make($param_name)->className('form-control')->setValue($value);
                    }
                    $form_fields[] = FieldsGroup::fields($fieldsGroup);
                }
            }
        }
        $form_fields[] = FieldsGroup::fields([
            ActionField::make('form_insert_shortcode_button')
                ->className('btn btn-primary form_insert_shortcode_button')
                ->attributes(['data-result' => $result])
                ->label('Insert'),
            ActionField::make('form_close_shortcode_button')
                ->className('btn btn-danger')
                ->attributes(['data-bs-dismiss' => 'modal', 'aria-label' => 'Close'])
                ->label('Close')
        ]);

        $html .= Form::id('form_insert_shortcode')
            ->routeAction('ajax.shortcode.get-shortcode')
            ->method('POST')
            ->className('bs5-form form-container')
            ->fields($form_fields)->render();
        $html .= "<script>" . file_get_contents(__DIR__ . '/../../../resources/dist/js/shortcode.js') . "</script>";

        return response()->json([
            'html' => $html
        ]);
    }

    public function getShortcode(Request $request)
    {
        $shortcode_params = '';
        $shortcode = $request->input('_shortcode', null);
        $result = $request->input('_result', null);
        if ($shortcode) {
            $shortcode_params .= '[' . $shortcode;
            foreach ($request->except(['_token', '_method', '_shortcode', '_result']) as $key => $item) {
                if (is_array($item)) {
                    $item = serialize($item);
                }
                $shortcode_params .= " " . $key . "='" . $item . "'";
            }
            $shortcode_params .= ']';
        }

        return response()->json([
            'shortcode' => $shortcode_params,
            'result' => $result
        ]);
    }
}
