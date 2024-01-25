<?php

namespace App\Models;

use App\Facades\Helper;
use App\Models\Concerns\ProductHasOption\HasRelationships;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class ProductHasOption extends Model
{
    use HasRelationships;

    protected $fillable = [
        'product_has_option_group_id',
        'product_option_id',
        'price_adjustment',
    ];

    protected $appends = [
        'price_adjustment_text',
    ];

    public function priceAdjustmentText(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->price_adjustment) {
                    return number_format($this->price_adjustment, 2)." ".Helper::setting()->currency->code;
                }

                return $this->productOption->price_adjustment_text;
            },
        );
    }
}
