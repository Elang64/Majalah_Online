<?php

namespace App\Exports;

use App\Models\Promo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\withHeadIngs;
use Maatwebsite\Excel\Concerns\withMapping;

class PromoExport implements FromCollection, withHeadIngs, withMapping
{
    private $key = 0;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Promo::orderBy('created_at', 'DESC')->get();
    }

    public function headings (): array
    {
        return ["No", 'Kode Promo', 'Total Potongan'];
    }

    public function map($promo):array
    {
          if ($promo->type === 'percent') {
            $totalPotongan = $promo->discount . '%';
        } else {
            $totalPotongan = 'Rp ' . number_format($promo->discount, 0, ',', '.');
        }

        return [
            ++$this->key,
            $promo->promo_code,
            $totalPotongan,
        ];
    }
}
