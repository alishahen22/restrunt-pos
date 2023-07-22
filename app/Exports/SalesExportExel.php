<?php

namespace App\Exports;

// use App\Models\Sale;
// use Illuminate\Contracts\View\View;
// use Maatwebsite\Excel\Concerns\FromView;
// class sales implements FromView
// {
//     private $dateEnd;
//     private $dateStart;
//     private $sales;
//    public function __construct($dateStart ,$dateEnd)
//     {
//         $this->dateStart = $dateStart;
//         $this->dateEnd = $dateEnd;
//         $sales = Sale::whereBetween('created_at', [ $this->dateStart,  $this->dateEnd])->get();
//     }
//     public function view(): View
//     {
//         return view('export.sale', [

//             'sales' => $this->sales,

//         ]);
//     }
// }
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    public function collection()
    {
        return User::all();
    }
}
