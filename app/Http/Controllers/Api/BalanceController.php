<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\History;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isNull;

class BalanceController extends Controller
{
    public function fill_balance(Request $request){
        $balance=Balance::all();
        $user=User::findOrFail($request->user_id);

       if($user){
           if(is_null( $user->balance)){
               $fillbalance=Balance::create([
                   'user_id'=>$request->get('user_id'),
                   'balance'=>$request->get('balance')
               ]);
               $fillhistory=History::create([
                   'user_id'=>$request->get('user_id'),
                   'amount_history'=>$request->get('balance')
               ]);
           }else{
               $fillbalance=Balance::find($balance['0']['id']);
               $fillbalance->user_id=$request->get('user_id');
               $fillbalance->balance=$balance['0']['balance']+$request->get('balance');
               $fillbalance->update();
               $fillhistory=History::create([
                   'user_id'=>$request->get('user_id'),
                   'amount_history'=>$request->get('balance')
               ]);
           }
           return response(['fillbalance'=>$fillbalance, 'fillhistory'=>$fillhistory]);
       };
    }

    public function fill_history(){
        $fillhistory=User::with('history')->get();
        return response(['fillhistory'=>$fillhistory['0']['history']]);
    }
}
