<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
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
            $category = Category::find($id);
            if ($category) {
                return ResponseFormatter::success($category,'Data category berhasil diambil');
            } else {
                return ResponseFormatter::error(null, 'Data category tidak ada', 404);
            }
        }
        $category = Category::paginate($limit);
        return ResponseFormatter::success(
            $category,
            'Data list category berhasil diambil'
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
    public function store(CategoryRequest $request)
    {
        $data = $request->all();
        $category = Category::create($data);
        if ($category) {
            return ResponseFormatter::success($category,'Category berhasil ditambahkan');
        } else {
            return ResponseFormatter::error(null, 'Category gagal ditambahkan', 404);
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
    public function update(CategoryRequest $request,$id)
    {
        $data = $request->all();
        $item = Category::findOrFail($id);
        $updated = $item->update($data);
        if ($updated) {
            return ResponseFormatter::success($updated,'Category berhasil diubah');
        } else {
            return ResponseFormatter::error(null, 'Category gagal diubah', 404);
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
        $item = Category::findOrFail($id);
        $deleted = $item->delete();
        if ($deleted) {
            return ResponseFormatter::success($deleted,'Category berhasil dihapus');
        } else {
            return ResponseFormatter::error(null, 'Category gagal dihapus', 404);
        }
    }
}
