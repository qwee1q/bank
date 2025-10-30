<?php

namespace App\Http\Controllers;

use App\Models\BankModel;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function main(){
        $bank_info = BankModel::all();
        $balance = 0;
        foreach ($bank_info as $el){
            if ($el->income_or_spending == 'spending'){
                $balance -= $el->sum;
            }
            else{
                $balance += $el->sum;
            }
        }
        return view('main', ['bank_info' => $bank_info->all()], ['balance' => $balance]);
    }

    public function check_bank(Request $request){
        $valid = $request->validate([
            'income_or_spending' => 'required|in:income,spending',
            'sum' => 'required|numeric',
            'comment' => 'required',
        ]);

        $bank_info = new BankModel();
        $bank_info -> income_or_spending = $request->input('income_or_spending');
        $bank_info -> sum = $request->input('sum');
        $bank_info -> comment = $request->input('comment');
        $bank_info -> save();


        return redirect()->route('main');
    }

    public function incomes(){
        $bank_info = BankModel::all();
        $all_incomes = 0;
        foreach ($bank_info as $el){
            if ($el->income_or_spending == 'income'){
                $all_incomes += $el->sum;
            }
        }
        return view('incomes', ['bank_info' => $bank_info->all()], ['all_incomes' => $all_incomes]);
    }

    public function spending(){
        $bank_info = BankModel::all();
        $all_spending = 0;
        foreach ($bank_info as $el){
            if ($el->income_or_spending == 'spending'){
                $all_spending -= $el->sum;
            }
        }
        return view('spending', ['bank_info' => $bank_info->all()], ['all_spending' => $all_spending]);
    }
}
