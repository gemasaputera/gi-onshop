<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit',6);
        if ($id) {
            $customer = Customer::find($id);
            if ($customer) {
                return ResponseFormatter::success($customer,'Data customer berhasil diambil');
            } else {
                return ResponseFormatter::error(null, 'Data customer tidak ada', 404);
            }
        }
        $customer = Customer::paginate($limit);
        return ResponseFormatter::success(
            $customer,
            'Data list customer berhasil diambil'
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
    public function store(CustomerRequest $request)
    {
        $data = $request->all();
        $customer = Customer::create($data);
        if ($customer) {
            return ResponseFormatter::success($customer,'Customer berhasil ditambahkan');
        } else {
            return ResponseFormatter::error(null, 'Customer gagal ditambahkan', 404);
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
    public function update(CustomerRequest $request, $id)
    {
        $data = $request->all();
        $item = Customer::findOrFail($id);
        $updated = $item->update($data);
        if ($updated) {
            return ResponseFormatter::success($updated,'Customer berhasil diubah');
        } else {
            return ResponseFormatter::error(null, 'Customer gagal diubah', 404);
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
        $item = Customer::findOrFail($id);
        $deleted = $item->delete();
        if ($deleted) {
            return ResponseFormatter::success($deleted,'Customer berhasil dihapus');
        } else {
            return ResponseFormatter::error(null, 'Customer gagal dihapus', 404);
        }
    }
}
