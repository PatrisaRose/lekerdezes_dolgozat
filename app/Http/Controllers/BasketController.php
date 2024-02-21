<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BasketController extends Controller
{
    public function index()
    {
        return response()->json(Basket::all());
    }

    public function show($user_id, $item_id)
    {
        $basket = Basket::where('user_id', $user_id)
            ->where('item_id', "=", $item_id)
            ->get();
        return $basket[0];
    }

    public function store(Request $request)
    {
        $item = new Basket();
        $item->user_id = $request->user_id;
        $item->item_id = $request->item_id;

        $item->save();
    }

    public function update(Request $request, $user_id, $item_id)
    {
        $item = $this->show($user_id, $item_id);
        $item->user_id = $request->user_id;
        $item->item_id = $request->item_id;

        $item->save();
    }

    public function destroy($user_id, $item_id)
    {
        $this->show($user_id, $item_id)->delete();
    }

    public function kosarbanLevoTermek()
    {
        $user = Auth::user();    //bejelentkezett felhasználó
        $basket = Basket::with('users')->where('user_id', '=', $user->id)->get();
        return $basket;
    }


    //jelenítsd meg az adott felhasználó (id a paraméter) kosara alapján azon termékeket, 
    //amelyek bizonyos terméktípushoz tartoznak (a típusnév is paraméter legyen); innentől DB:table...
    public function masodikFeladat($user_id, $type_name)
    {
        $baskets = DB::table('baskets as b')
            ->select('t.type_id', 't.name')
            ->join('users as u', 'b.user_id', '=', 'u.id')
            ->join('products as p', 'b.item_id', '=', 'p.item_id')
            ->join('product_types as t', 'p.type_id', '=', 't.type_id')
            ->where('b.user_id', '=', $user_id)
            ->where('t.name', '=', $type_name) 
            ->get();
        return $baskets;
    }

    //Töröld az összes 2 napnál régebbi kosár tartalmakat!

    public function harmadikFeladat(){
        $baskets = DB::table('baskets')
        ->whereDate('updated_at', '<=', now() -> subDays(2))
        ->delete();
        return $baskets;
        
    }
}
