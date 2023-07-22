<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Table;
use Illuminate\Http\Request;

class cashierController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('cashier.index' , compact('categories'));
    }
    public function getTable(){
       $tables = Table::all();
       $html = '';
        foreach($tables as $table){
             $html .= '<div class="col-2  text-center mb-3">';
             $html .= '<button class="btn btn-primary table-btn" data-id="'.$table->id.'" data-name = "'.$table->name.'" >
                        <img class="img-fluid" src="'.asset("image/table.png").'" alt="">' ;
                        if ($table->status == 'available') {
                            $html .= '<span class="badge bg-success">'.$table->name.'</span>';
                        }
                        else{
                            $html .= '<span class="badge bg-danger">'.$table->name.'</span>';
                        }
               $html .= '</button>';
             $html .= '</div>';

        }
        return $html;
    }

    public function getmenu($category_id){
       $menus = Menu::where('category_id',$category_id)->get();
         $html = '';
          foreach($menus as $menu){
                 $html .= '<div class="col-3  text-center ">';
                 $html .= '<a class="btn btn-outline-secondary order" data-id="'.$menu->id.'">
                            <img class="img-fluid"  src="'.asset("menueImages/".$menu->image).'">
                            <br>
                            <span ">'. $menu->name.'</span> <br>
                           $<span ">'.number_format($menu->price) .'</span> <br>

                            </a>';
                 $html .= '</div>';

          }
          return $html;
    }

    public function saveOrder(Request $request)
    {
//paid unpaid
         $menu = Menu::find($request->menu_id);
         //get sale if exists
         $sale = Sale::where('table_id',$request->table_id)->where('status','unpaid')->first();
         if(!$sale){
            $sale = Sale::create([
                'table_id' => $request->table_id,
                'user_id' => auth()->user()->id,

            ]);
            $table = Table::find($request->table_id);
            $table->status = 'unavailable';
            $table->save();
           }

           //add order in sale_details
         $sale_details = new SaleDetail();
            $sale_details->sale_id = $sale->id;
            $sale_details->menu_id = $menu->id;
            $sale_details->menu_name = $menu->name;
            $sale_details->menu_price = $menu->price;
            $sale_details->quentity = $request->quantity;
            $sale_details->save();

            //update total
            $sale->total_price = $sale->total_price + ($menu->price * $request->quantity);
            $sale->save();

            //html code for order
            $sale_details = SaleDetail::where('sale_id',$sale->id)->get();
            $html = $this->getdetailsHtml($sale_details);
            return  $html;

    }
    public function getOrderByTable($table_id)
    {
        $sale = Sale::where('table_id',$table_id)->where('status','unpaid')->first();
    //    $sale_details =  SaleDetail::where('table_id',$table_id)->where('staus','noconfirm')->get();
        if ($sale) {
            $sale_details = SaleDetail::where('sale_id',$sale->id)->get();
            $html = $this->getdetailsHtml($sale_details);
         //   dd( $sale_details ) ;
        }else {

            $html = '<h3 class="text-center">No Order yet</h3>';

        }

        return $html;
    }
    public function confirmOrder(Request $request)
    {

         SaleDetail::where('sale_id',$request->sale_id)->update(['status'=>'confirm']);
         $sale_details = SaleDetail::where('sale_id',$request->sale_id)->get();
        return $this->getdetailsHtml($sale_details);
    }


    // <i class="fa-solid fa-check"></i>

    public function deleteMenu(Request $request)
    {

            $sale_detail = SaleDetail::find($request->sale_detail);
            $sale_id = $sale_detail->sale_id;
            $sale = Sale::find($sale_id);
            $sale->total_price = $sale->total_price - ($sale_detail->menu_price * $sale_detail->quentity);
            $sale->save();
            $sale_detail->delete();
            $sale_details = SaleDetail::where('sale_id',$sale_id)->get();
            if (count($sale_details) > 0) {
                return $this->getdetailsHtml($sale_details);
            }
            else{
                $sale->delete();
                $table = Table::find($sale->table_id);
                $table->status = 'available';
                $table->save();
                return '<h3 class="text-center">No Order yet</h3>';
            }

    }

    public function savePayment(Request $request)
    {
        $request->validate([
            'total_recieved' => 'required|numeric',
            'payment_type'=>'required|in:cash,card'
        ]);
        $sale = Sale::find($request->sale_id);
        $sale->status = 'paid';
        $sale->payment_type = $request->payment_type;
        $sale->total_recieved = $request->total_recieved;
        $sale->change =  $request->total_recieved - $request->total_price ;
        $sale->save();
        $table = Table::find($sale->table_id);
        $table->status = 'available';
        $table->save();
        return '/cachier/showreceipt/'.$sale->id;
    }


    public function showReceipt($id)
    {
        $sale = Sale::findOrFail($id);
        $saleDetails = SaleDetail::where('sale_id',$id)->get();
        return view('cashier.showReceipt',compact('sale','saleDetails'));
    }














    private function getdetailsHtml($sale_details){
        $html = '<div style = "overflow-y:scroll; height:360px; border:1px solid #343A40 " >
        <table class="table table-dark table-striped text-center"  >
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Menu</th>
            <th scope="col">Quantity</th>
            <th scope="col">price</th>
            <th scope="col">Total</th>
            <th scope="col">Status</th>

          </tr>
        </thead>
        <tbody>';
        $show_payment_btn = true;
        $i = 0;
        foreach ($sale_details as $sale_detail) {

            $i++;
            if (  $sale_detail->status == 'noconfirm') {
                $show_payment_btn = false;
                $icon = '<a class="trath-btn" data-id =" '.$sale_detail->id . '">  <i class="fa-solid fa-trash-can p-1" style="color:white; background-color:red"></i> </a>';
            }else {
                $icon = '<i class="fa-solid fa-check" style="color: #73fd73;" ></i>';
            }
            $sale_id= $sale_detail->sale_id;
            $html .= '<tr>
            <th scope="row">'.$i.'</th>
            <td>'.$sale_detail->menu_name.'</td>
            <td>'.$sale_detail->quentity.'</td>
            <td>'.$sale_detail->menu_price.'</td>
            <td>'.$sale_detail->quentity * $sale_detail->menu_price.'</td>
            <td>'.$icon.'</td>
          </tr>';
        }

      $html .= ' </tbody>
               </table> </div>';
      $sale = Sale::find($sale_id);
        $html .= '<h3 class="my-4">Total : $'.number_format($sale->total_price).'</h3>';
      if ($show_payment_btn) {
        $html .= '  <button class="btn btn-success w-100 mb-3 payment-btn"  data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="'.$sale->id.'" data-amount="'.$sale->total_price.'" >payment</button>';
      } else {
        $html .= ' <button class="btn btn-warning w-100 mb-3 confirm-btn" data-id="'.$sale->id.'" >confirm</button>  ';

      }

        return $html;

    }
}
