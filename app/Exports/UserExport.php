<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\withHeadIngs;
use Maatwebsite\Excel\Concerns\withMapping;
use Carbon\Carbon;


class UserExport implements FromCollection, withHeadIngs, withMapping
{
    private $key = 0;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::whereIn('role', ['admin'])->orderBy('created_at', 'ASC')->get();
    }

      public function headings(): array
    {
        return["No", 'Nama', 'Email', 'Role', 'Tanggal Bergabung'];
    }

    // menentuka td
    public function map($user): array
    {
         $users = User::whereIn('role', 'admin');


            // menambahkan $key diatas dr 1 dst
           return [
            ++$this->key, // Auto increment nomor
            $user->name,  // atau $user->name kalau field-nya name
            $user->email,
            $user->role,
            Carbon::parse($user->created_at)->format('d-m-Y'),
        ];
    }
}
