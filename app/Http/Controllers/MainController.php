<?php

namespace App\Http\Controllers;

use App\Models\BankModel;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function main(){
        $bank_info = new BankModel();
        return view('main', ['bank_info' => $bank_info->all()]);
    }

    public function check_bank(Request $request){
        $valid = $request->validate([
            'income_or_spending' => 'required',
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
        $bank_info = new BankModel();
        return view('incomes', ['bank_info' => $bank_info->all()]);
    }

    public function spending(){
        $bank_info = new BankModel();
        return view('spending', ['bank_info' => $bank_info->all()]);
    }
}
