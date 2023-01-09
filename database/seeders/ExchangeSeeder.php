<?php

namespace Database\Seeders;

use App\Models\ExchangeRate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExchangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exchange = new ExchangeRate();
        $exchange->SourceCurrency = 'GBP';
        $exchange->TargetCurrency = 'TRY';
        $exchange->Value = null;
        $exchange->TradingDate = null;
        $exchange->save();

        $exchange = new ExchangeRate();
        $exchange->SourceCurrency = 'USD';
        $exchange->TargetCurrency = 'TRY';
        $exchange->Value = null;
        $exchange->TradingDate = null;
        $exchange->save();

        $exchange = new ExchangeRate();
        $exchange->SourceCurrency = 'EUR';
        $exchange->TargetCurrency = 'TRY';
        $exchange->Value = null;
        $exchange->TradingDate = null;
        $exchange->save();

        $exchange = new ExchangeRate();
        $exchange->SourceCurrency = 'CHF';
        $exchange->TargetCurrency = 'TRY';
        $exchange->Value = null;
        $exchange->TradingDate = null;
        $exchange->save();

        $exchange = new ExchangeRate();
        $exchange->SourceCurrency = 'RUB';
        $exchange->TargetCurrency = 'TRY';
        $exchange->Value = null;
        $exchange->TradingDate = null;
        $exchange->save();
    }
}
