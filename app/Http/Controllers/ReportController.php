<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use app\Exports\sales;
use Maatwebsite\Excel\Facades\Excel;
//use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
   public function index()
   {
     return view('report.index');

   }
   public function getReport(Request $request)
   {
        if ($request->startDate == null || $request->endDate == null || $request->startDate > $request->endDate) {
            return redirect()->back()->with('error', 'Please select correct date range');
        }
        $fromDate = $request->startDate;
        $toDate = $request->endDate;
        $sales = Sale::whereBetween('created_at', [$fromDate, $toDate])->get();
        $totalPrice = 0;
        foreach ($sales as $sale) {
            $totalPrice += $sale->total_price;
        }
        return view('report.getReports', compact('sales' , 'totalPrice','fromDate' ,'toDate' ));
   }

   function showExel(Request $request)
   {
    // $fromDate = $request->dateStart;
    // $toDate = $request->dateEnd;
    // $sales = Sale::whereBetween('created_at', [$fromDate, $toDate])->get();
    // return $fromDate;
//    return Excel::download(new sales($request->dateStart, $request->dateEnd), 'invoices.xlsx');
    return Excel::download(new sales, 'users.xlsx');

}
}
