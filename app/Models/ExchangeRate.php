<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * This is the model class for table "exchange_rates".
 *
 * @property int $id
 * @property string $SourceCurrency
 * @property string $TargetCurrency
 * @property string $Value
 * @property string $TradingDate
 */
class ExchangeRate extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;
}
