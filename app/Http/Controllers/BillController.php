<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /**
         * Verifica se o usuário é admin
         * Se for exibe todas as contas
         * Caso não seja exibe apenas as contas vinculadas ao usuário logado
         */

        if (Auth::user()->role == 'admin') {
            $bills = Bill::all();
            return view('bills.index', compact('bills'));
        } else {
            $bills = Bill::where('user_id', Auth::user()->id)->get();
            return view('bills.index', compact('bills'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bills.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100|string',
            'description' => 'required|max:255|string',
            'value' => 'required|numeric|gt:0',
            'due_date' => 'required|date',
        ]);

        $bill = new Bill();
        $bill->name = $request->name;
        $bill->description = $request->description;
        $bill->value = $request->value;
        $bill->due_date = $request->due_date;
        $bill->user_id = Auth::user()->id;

        if ($bill->save()) {
            return redirect()->route('bills.index')->with('success', 'Conta adicionada com sucesso!');
        } else {
            return redirect()->route('bills.index')->with('error', 'Erro ao adicionar conta.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Bill $bill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bill $bill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bill $bill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bill $bill)
    {
        //
    }
}
