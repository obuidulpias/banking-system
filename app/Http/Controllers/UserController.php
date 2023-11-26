<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserController extends Controller
{
    public function createUser(Request $request)
    {
        return redirect('/register');
    }
    public function showDeposit()
    {
        $id =  Auth::id();
        if($id==null){
            //echo "Need to login....";
            return redirect('/login');
        }
        //$depositData=Transaction::all()->where('transaction_type', 'Deposit');
        $depositData = DB::table('transactions')->where('user_id', $id)->where('transaction_type', "Deposit")->get();
        //dd($depositData);
        //echo "sure";
        return view('user.show-deposit', ['deposits' => $depositData,]);
    }
    public function showWithdrawal()
    {
        $id =  Auth::id();
        if($id==null){
            //echo "Need to login....";
            return redirect('/login');
        }
        $withdrawalData = DB::table('transactions')->where('user_id', $id)->where('transaction_type', "Withdrawal")->get();
        //dd($depositData);
        //echo "sure";
        return view('user.show-withdrawal', ['withdrawals' => $withdrawalData,]);
    }
    public function showTrans()
    {
        $id =  Auth::id();
        if($id==null){
            //echo "Need to login....";
            return redirect('/login');
        }
        $main_query = DB::table('users')
            //->join('transactions b', 'a.id', '=', 'b.user_id')
            ->join('transactions', 'users.id', '=', 'transactions.user_id')
            ->select('users.name','users.balance','transactions.transaction_type','transactions.amount')
            ->where('transactions.user_id', $id)
            ->get();
            //dd($main_query);
        return view('user.show', ['datas' => $main_query,]);
    }
    public function createDeposit(Request $request)
    {
        $id =  Auth::id();
        if($id==null){
            //echo "Need to login....";
            return redirect('/login');
        }
        return view('user.create-deposit', [
            'deposit' => $request->user(),
        ]);
    }
    public function createNewDeposit(Request $request)
    {
        $id =  Auth::id();
        //dd($id);
        //Session::put('studentId', $studentId);
        if($id==null){
            //echo "Need to login....";
            return redirect('/login');
        }
        
        $transaction = new Transaction();
        $transaction ->user_id              = $id;
        $transaction ->amount               = $request -> deposit_amount;

        $transaction ->fee                  = 0;       
        $transaction -> transaction_type    = $request -> transactions_type;
        $transaction -> date                = Carbon::now();
        $transaction -> save();
        $user_balance = DB::table('users')->where('id', $id)->first();
         //dd($user_balance->balance);
        User::where('id','=', $id)
        ->update([
            'balance' => $request->deposit_amount+$user_balance->balance,
        ]);



      return redirect('/create-deposit')->with('message', 'Deposit amount save successfully');

    }

    public function createWithdrawal(Request $request)
    {
        $id =  Auth::id();
        if($id==null){
            //echo "Need to login....";
            return redirect('/login');
        }
        return view('user.create-withdrawal');
    }
    public function createNewWithdrawal(Request $request)
    {
        $id =  Auth::id();
        //dd($id);
        //Session::put('studentId', $studentId);
        if($id==null){
            //echo "Need to login....";
            return redirect('/login');
        }
        //Carbon::now()->format('1m')
        $first_day_month=Carbon::now()->firstOfMonth()->format('y-m-d');
        $last_day_month=Carbon::now()->lastOfMonth()->format('y-m-d');
        
        //dd($count_row);die;
        $user_info = DB::table('users')->where('id', $id)->first();
        if($user_info->account_type=='Individual'){
            $rate_based_deduc=(($request -> withdrawal_amount*0.015)/100);
            if(Carbon::now()->format('D')=="Fri"){
                $rate_based_deduc=0; 
            }
            $count_row=Transaction::find($id)->where('transaction_type','Withdrawal')->count();
            if($count_row==0 && $request->withdrawal_amount<1000){
                $rate_based_deduc=0;
            }
            $count_monthly=Transaction::find($id)->where('transaction_type','Withdrawal')->whereBetween('date', [$first_day_month, $last_day_month])->count();
            if($count_monthly==0){
                $rate_based_deduc=0;
            }          
            
            //$total_deduct=$rate_based_deduc

        }elseif($user_info->account_type=='Business'){
            $sum_amount=Transaction::find($id)->where('transaction_type','Withdrawal')->sum('amount');
            if($sum_amount>50000){
                $rate_based_deduc=(($request -> withdrawal_amount*0.015)/100);
            }else{
                $rate_based_deduc=(($request -> withdrawal_amount*0.025)/100);
            }
            
        }
        $withdrawal_amount=$request->withdrawal_amount-$rate_based_deduc;
        //dd($withdrawal_amount);
        
        $transaction = new Transaction();
        $transaction ->user_id              = $id;
        $transaction ->amount               = $withdrawal_amount;

        $transaction ->fee                  = $rate_based_deduc;       
        $transaction -> transaction_type    = $request -> transactions_type;
        $transaction -> date                = Carbon::now();
        $transaction -> save();
        $user_balance = DB::table('users')->where('id', $id)->first();
         //dd($user_balance->balance);
        User::where('id','=', $id)
        ->update([
            'balance' => $user_balance->balance-$withdrawal_amount,
        ]);



      return redirect('/create-withdrawal')->with('message', 'Withdrawal amount save successfully');

    }
}
