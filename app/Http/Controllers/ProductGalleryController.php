<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductGalleryRequest;
use App\Models\ProductGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductGalleryController extends Controller
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
            $items = ProductGallery::with('product')->get();
            if ($items) {
                return ResponseFormatter::success($items,'Data product gallery berhasil diambil');
            } else {
                return ResponseFormatter::error(null, 'Data product gallery tidak ada', 404);
            }
        }
        $items = ProductGallery::paginate($limit);
        return ResponseFormatter::success(
            $items,
            'Data list product gallery berhasil diambil'
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
    public function store(ProductGalleryRequest $request)
    {
        $data = $request->all();
        $data['photo'] = $request->file('photo')->store(
            'assets/product', 'public'
        );
        $product_galleries = ProductGallery::create($data);
        if ($product_galleries) {
            return ResponseFormatter::success($product_galleries,'Product gallery berhasil ditambahkan');
        } else {
            return ResponseFormatter::error(null, 'Product gallery gagal ditambahkan', 404);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = ProductGallery::findOrFail($id);
        $deleted = $item->delete();
        if ($deleted) {
            return ResponseFormatter::success($deleted,'Product gallery berhasil dihapus');
        } else {
            return ResponseFormatter::error(null, 'Product gallery gagal dihapus', 404);
        }
    }
}
