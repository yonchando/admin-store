<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductOptionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product_options' => 'required|array',
            'product_options.*.product_option_group_id' => 'required|int',
            'product_options.*.options.*.product_option_id' => 'required|int',
            'product_options.*.options.*.price_adjustment' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    public function attributes(): array
    {
        return [
            'product_options.*.product_option_group_id' => __('lang.product_option_group'),
            'product_options.*.options.*.product_option_id' => __('lang.product_option'),
            'product_options.*.options.*.price_adjustment' => __('lang.price_adjustment'),
        ];
    }


    public function authorize(): bool
    {
        return true;
    }
}
