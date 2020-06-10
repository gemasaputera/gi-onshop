<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Support\Str;

class ProductController extends Controller
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
        $name = $request->input('name');
        $slug = $request->input('slug');
        $type = $request->input('type');
        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');
        
        if ($id) {
            $product = Product::with('galleries')->find($id);
            if ($product) {
                return ResponseFormatter::success($product,'Data produk berhasil diambil');
            } else {
                return ResponseFormatter::error(null, 'Data produk tidak ada', 404);
            }
        }
        if ($slug) {
            $product = Product::with('galleries')->where('slug', $slug)->first();
            if ($product) {
                return ResponseFormatter::success($product,'Data produk berhasil diambil');
            } else {
                return ResponseFormatter::error(null, 'Data produk tidak ada', 404);
            }
        }
        $product = Product::with('galleries');
        if ($name)
            $product->where('name','like','&'.$name.'%');
        if ($type)
            $product->where('type','like','&'.$type.'%');
        if ($price_from)
            $product->where('price','>=',$price_from);
        if ($price_to)
            $product->where('price','<=',$price_to);
        return ResponseFormatter::success(
            $product->paginate($limit),
            'Data list produk berhasil diambil'
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
    public function store(ProductRequest $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        $product = Product::create($data);
        if ($product) {
            return ResponseFormatter::success($product,'Data produk berhasil ditambahkan');
        } else {
            return ResponseFormatter::error(null, 'Data produk gagal ditambahkan', 404);
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
    public function update(ProductRequest $request, $id)
    {
        $data = $request->all();
        $item = Product::findOrFail($id);
        $updated = $item->update($data);
        if ($updated) {
            return ResponseFormatter::success($updated,'Product berhasil diubah');
        } else {
            return ResponseFormatter::error(null, 'Product gagal diubah', 404);
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
        $item = Product::findOrFail($id);
        $deleted = $item->delete();
        ProductGallery::where('products_id',$id)->delete();
        if ($deleted) {
            return ResponseFormatter::success($deleted,'Product berhasil dihapus');
        } else {
            return ResponseFormatter::error(null, 'Product gagal dihapus', 404);
        }
    }
}
