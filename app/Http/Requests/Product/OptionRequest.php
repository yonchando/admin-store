<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OptionRequest extends FormRequest
{
    public function rules(): array
    {
        return [

            'options' => 'required|array',
            'options.*.product_option_id' => [
                'required', 'int',
                Rule::exists('product_options', 'id'),
            ],
            'options.*.product_has_option_group_id' => [
                'required', 'int',
                Rule::exists('product_has_option_groups', 'id'),
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'options.*.product_option_id' => __('lang.product_option'),
            'options.*.product_has_option_group_id' => __('lang.product_option_group'),
        ];
    }


    public function authorize(): bool
    {
        return true;
    }
}
