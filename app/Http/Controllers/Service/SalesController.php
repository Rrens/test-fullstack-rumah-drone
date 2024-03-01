<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\History;
use App\Models\Minmax;
use App\Models\ProductItems;
use App\Models\ProductCategory;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Supplier;
use App\Models\User;
use App\Traits\MyTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class SalesController extends Controller
{
    use MyTrait;
    public function invoice()
    {
        // $lastRecord = Sale::latest()->first();
        $lastRecord = Sale::count();
        $lastID = $lastRecord ? $lastRecord : 0;

        $newID = 'MP' . date('ym') . str_pad($lastID + 1, 4, '0', STR_PAD_LEFT);
        return $newID;
    }

    public function check_min_stock($id)
    {
        $current = Carbon::now()->format('m');

        $jum_hari = DB::table('history')
            ->select(DB::raw('DAY(LAST_DAY(date)) as jum_hari'))
            ->whereMonth('date', $current)
            ->where('item_id', $id)
            ->get();

        foreach ($jum_hari as $item) {
            $jum_hari = $item->jum_hari;
        }

        $hitung = DB::table('history')
            ->join("product_items", function ($join) {
                $join->on("product_items.id", "=", "history.item_id");
            })
            //->select(DB::raw('MAX(total) as besar, round(SUM(total)/30) as rata'))
            ->select(DB::raw('*,MAX(total) as besar, SUM(total) as rata'))
            ->whereMonth('date', $current)
            ->where('item_id', $id)
            ->groupBy('product_items.id')
            ->get();


        // dd($data);

        $data_part = DB::table('product_items')
            ->join("history", function ($join) {
                $join->on("product_items.id", "=", "history.item_id");
            })
            ->whereMonth('history.date', $current)
            ->where('product_items.id', $id)
            ->select("product_items.id as id_part", "product_items.name as nm_motor", "product_items.stock as stok", "product_items.lead_time as time")
            ->groupBy('product_items.id')
            ->get();
        // dd($data_part);
        $stock_min = ceil($hitung[0]->rata / $jum_hari) * $data_part[0]->time + ($hitung[0]->besar - ceil($hitung[0]->rata / $jum_hari)) * $data_part[0]->time;
        $safety_stock = ($hitung[0]->besar - ceil($hitung[0]->rata / $jum_hari)) * $data_part[0]->time;
        return response()->json([
            'stock_min' =>  $stock_min,
            'safety_stock' => $safety_stock
        ]);
    }

    public function index()
    {
        $active = 'transaction';
        $active_detail = 'sales';
        $customers = Customer::all();
        $carts = Cart::with('item')->where('user_id', 1)->get();
        $product_item = ProductItems::all();
        $product_kategori = ProductCategory::all();
        $invoice = $this->invoice();
        // dd($invoice);
        $date = Carbon::today()->format('Y-m-d');
        // dd($date);

        return view('pages.Transaction.sales', compact(
            'active',
            'active_detail',
            'customers',
            'carts',
            'product_item',
            'product_kategori',
            'invoice',
            'date',
        ));
    }

    public function cart_data()
    {
        $data = Cart::with('item')->where('user_id', 1)->get();
        return view('pages.Transaction.cart-data', compact('data'));
    }

    public function add_cart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required|exists:product_items,id',
            'price' => 'required|numeric',
            'jual' => 'required|numeric',
            'qty' => 'required|numeric',
            'user_id' => 'required|exists:users,name'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
        }

        $user = User::where('name', $request['user_id'])->pluck('id');
        // return response()->json($user[0]);

        try {

            $data = Cart::where('item_id', $request['item_id'])
                ->where('user_id', Auth::user()->id)
                ->first();

            if (!empty($data)) {
                $data->jumlah_jual += $request['jual'];
                $data->quantity += $request['qty'];
            } else {
                $data = new Cart();
                $data->item_id = $request['item_id'];
                $data->user_id = $user[0];
                $data->price = $request['price'];
                $data->jumlah_jual  = $request['jual'];
                $data->quantity  = $request['qty'];
            }
            $data->total = $data->price * $data->jumlah_jual;
            $data->save();

            return response()->json([
                'success' => true
            ]);
        } catch (Exception $error) {
            return response()->json($error);
        }
    }

    // public function minmax($item_id)
    // {
    //     $product_item = ProductItems::findOrFail($item_id);
    //     $minmax = Minmax::where('item_id', $item_id)->get();
    //     $minmax->stock = $product_item->stock;
    // }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'discount' => 'nullable|numeric',
            'item_id' => 'required|exists:product_items,id',
            'price' => 'required',
            'jumlah_jual' => 'required',
            'quantity' => 'required',
            'total' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
        }

        try {
            $data = Cart::where('item_id', $request['item_id'])->first();
            $data->discount_item = $request['discount'];
            $data->price = $request['price'];
            $data->jumlah_jual = $request['jumlah_jual'];
            $data->quantity = $request['quantity'];
            $data->total = $request['total'];
            $data->save();

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (Exception $error) {
            return response()->json($error);
        }
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:carts,id'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
        }

        try {
            Cart::where('id', $request['id'])->delete();

            return response()->json([
                'success' => true
            ]);
        } catch (Exception $error) {
            return response()->json($error);
        }
    }

    public function store_sale(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'grandtotal' => 'required',
            'service' => 'nullable',
            'subtotal' => 'required',
            'note' => 'nullable',
            'cash' => 'required',
            'change' => 'required',
            'customer_id' => 'required'
        ]);


        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
        }

        if ($request['customer_id'] == "Umum") {
            $request['customer_id'] = null;
        }

        // dd($request->all());

        $cart = Cart::where('user_id', Auth::user()->id)->get();

        try {
            $data = new Sale();
            $data->invoice = $this->invoice();
            $data->customer_id = $request['customer_id'];
            $data->user_id = Auth::user()->id;
            $data->total_price = $request['subtotal'];
            $data->service = $request['service'];
            $data->final_price = $request['grandtotal'];
            $data->cash = $request['cash'];
            $data->remaining = $request['change'];
            $data->note = $request['note'];
            $data->date = Carbon::today();
            $data->save();
            foreach ($cart as $item) {
                $data_detail = new SaleDetail();
                $data_detail->sale_id = $data->id;
                $data_detail->item_id = $item->item_id;
                $data_detail->price = $item->price;
                $data_detail->jual = $item->jumlah_jual;
                // dd($item);
                $data_detail->qty = $item->quantity;
                // $data_detail->jual = $item->jumlah_jual;
                $data_detail->discount_item = $item->discount_item;
                $data_detail->total = $item->total;
                $data_detail->save();

                $product_item = ProductItems::where('id', $item->item_id)->first();
                $product_item->stock -= $item->jumlah_jual;
                $product_item->save();

                $history = new History();
                $history->item_id = $item->item_id;
                $history->date = Carbon::today();
                $history->total = $item->quantity;
                $history->save();

                $this->minmax($item->item_id, $item->quantity);
                // dd($request->all(), $item);
            }

            Cart::where('user_id', Auth::user()->id)->delete();

            return response()->json([
                'sale_id' => $data->id,
                'success' => true
            ]);
        } catch (Exception $error) {
            return response()->json($error);
        }
    }

    public function cancel_sale(Request $request)
    {
        try {
            Cart::where('user_id', 1)->delete();
            return response()->json([
                'success' => true
            ]);
        } catch (Exception $error) {
            return response()->json($error);
        }
    }

    public function print($id)
    {
        $data = Sale::with('user', 'customer')->where('id', $id)->first();
        $data_detail = SaleDetail::with('item')->where('sale_id', $id)->get();
        // dd($data, $data_detail);
        return view('pages.Transaction.print', compact('data', 'data_detail'));
    }
}
