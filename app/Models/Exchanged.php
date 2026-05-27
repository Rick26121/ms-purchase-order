<?php
// En App/Models/ExchangeRate.php
namespace App\Models;

class ExchangeRate
{
    public float $usd;
    public float $eur;
    public string $date;
    
    public static function fromApiResponse(array $data): self
    {
        $exchangeRate = new self();
        $exchangeRate->usd = $data['current']['usd'];
        $exchangeRate->eur = $data['current']['eur'];
        $exchangeRate->date = $data['current']['date'];
        
        return $exchangeRate;
    }
}

