<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ExchangeRate extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function($exchangeRate) {
            return [
                'id' => $exchangeRate->id,
                'To' => $exchangeRate->TargetCurrency,
                'From' => $exchangeRate->SourceCurrency,
                'Value' => $exchangeRate->Value,
                'Date' => $exchangeRate->TradingDate
            ];
        });
    }
}
