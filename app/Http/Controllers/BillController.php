<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('search') || $request->has('client_side')) {
            // Fetch all bills for search functionality or client-side operations
            if (Auth::user()->isAdmin()) {
                $bills = Bill::with('user')->get();
            } else {
                $bills = Bill::with('user')->where('user_id', Auth::user()->id)->get();
            }
            return response()->json($bills);
        } else {
            // Fetch paginated bills for normal view
            if (Auth::user()->isAdmin()) {
                $bills = Bill::with('user')->paginate(10);
            } else {
                $bills = Bill::with('user')->where('user_id', Auth::user()->id)->paginate(10);
            }
            return view('bills.index', compact('bills'));
        }
    }


    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $users = User::all();
        $isAdmin = Auth::user()->isAdmin();
        return view('bills.create', compact('users', 'isAdmin'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:100|string',
            'description' => 'required|max:255|string',
            'amount' => 'required|numeric|gt:0',
            'due_date' => 'required|date',
            'user_id' => 'required|exists:users,id'
        ]);

        $bill = new Bill();
        $bill->title = $request->title;
        $bill->description = $request->description;
        $bill->amount = $request->amount;
        $bill->due_date = $request->due_date;
        $bill->user_id = $request->user_id;

        if ($bill->save()) {
            return redirect()->route('bills.index')->with('success', 'Conta adicionada com sucesso!');
        } else {
            return redirect()->route('bills.index')->with('error', 'Erro ao adicionar conta.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bill $bill)
    {
        return view('bills.edit', compact('bill'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bill $bill)
    {
        if (Auth::user()->can('update', $bill)) {
            $request->validate([
                'title' => 'required|max:100|string',
                'description' => 'required|max:255|string',
                'amount' => 'required|numeric|gt:0',
                'due_date' => 'required|date',
                'status' => 'required|in:paid,pending'
            ]);

            $bill->title = $request->title;
            $bill->description = $request->description;
            $bill->amount = $request->amount;
            $bill->due_date = $request->due_date;
            $bill->status = $request->status;

            if ($bill->save()) {
                return redirect()->route('bills.index')->with('success', 'Conta atualizada com sucesso!');
            } else {
                return redirect()->route('bills.index')->with('error', 'Erro ao atualizar conta.');
            }
        } else {
            return redirect()->route('bills.index')->with('error', 'Você não tem permissão para isto.');
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bill $bill)
    {
        if (Auth::user()->can('delete', $bill)) {
            $bill->delete();
            return redirect()->route('bills.index')->with('success', 'Conta deletada com sucesso!');
        } else {
            return redirect()->route('bills.index')->with('error', 'Você não tem permissão para isto.');
        }
    }
}
