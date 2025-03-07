<?php

namespace App\Models;

use App\Facades\Helper;
use App\Models\Concerns\ProductHasOption\HasRelationships;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductHasOption extends Model
{
    use HasRelationships;
    use HasFactory;

    protected $fillable = [
        'product_has_option_group_id',
        'product_option_id',
        'price_adjustment',
    ];

    protected $appends = [
        'price_adjustment_text',
    ];

    protected $casts = [
        'price_adjustment' => 'decimal:2',
    ];

    public function priceAdjustmentText(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->price_adjustment) {
                    return number_format($this->price_adjustment, 2)." ".Helper::setting()?->currency->code;
                }

                return $this->productOption->price_adjustment_text;
            },
        );
    }
}
