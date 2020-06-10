<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TransactionRequest;
use App\Models\TransactionDetail;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit',5);
        if ($id) {
            $transaction = Transaction::with('details.product','details.customer')->findOrFail($id);
            if ($transaction) {
                return ResponseFormatter::success($transaction,'Data transaction berhasil diambil');
            } else {
                return ResponseFormatter::error(null, 'Data transaction tidak ada', 404);
            }
        }
        $transaction = Transaction::paginate($limit);
        return ResponseFormatter::success(
            $transaction,
            'Data list transaction berhasil diambil'
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $request)
    {
        $data = $request->except('transaction_details');
        $data['uuid'] = 'TRX' . mt_rand(10000,99999) . mt_rand(100,999);
        
        $transaction = Transaction::create($data);

        foreach ($request->transaction_details as $product)
        {
            $details[] = new TransactionDetail([
                'customers_id' => $request['customers_id'],
                'transactions_id' => $transaction->id,
                'products_id' => $product,
            ]);

            Product::find($product)->decrement('quantity');
        }

        $transaction->details()->saveMany($details);
        if ($transaction) {
            return ResponseFormatter::success($transaction,'Data berhasil ditambahkan');
        } else {
            return ResponseFormatter::error($null,'Data gagal ditambahkan', 404);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:PENDING,SUCCESS,FAILED'
        ]);

        $item = Transaction::findOrFail($id);
        $item->transaction_status = $request->status;
        $status = $item->save();
        if ($status) {
            return ResponseFormatter::success($status,'Transaction status berhasil diubah');
        } else {
            return ResponseFormatter::error(null, 'Transaction status gagal diubah', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Transaction::findOrFail($id);
        $deleted = $item->delete();
        if ($deleted) {
            return ResponseFormatter::success($deleted,'Transaction berhasil dihapus');
        } else {
            return ResponseFormatter::error(null, 'Transaction gagal dihapus', 404);
        }
    }
}
