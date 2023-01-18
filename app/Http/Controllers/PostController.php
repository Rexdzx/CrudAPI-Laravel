<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->get();
        return response()->json([
            'data' => PostResource::collection($posts),
            'message' => 'Mengambil Semua Data',
            'success' => true,
        ]);
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:150',
            'content' => 'required',
            'status' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false,
            ]);
        }

        $post = Post::create([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'status' => $request->get('status'),
            'slug' => Str::slug($request->get('title')),
        ]);

        return response()->json([
            'data' => new PostResource($post),
            'message' => 'Berhasil Membuat Postingan',
            'success' => true,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return response()->json([
            'data' => new PostResource($post),
            'message' => 'Data Postingan Ditemukan',
            'success' => true,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:150',
            'content' => 'required',
            'status' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false,
            ]);
        }

        $post->update([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'status' => $request->get('status'),
            'slug' => Str::slug($request->get('title')),
        ]);

        return response()->json([
            'data' => new PostResource($post),
            'message' => 'Data Berhasil Diubah',
            'success' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json([
            'data' => new PostResource($post),
            'message' => 'Data Berhasil Dihapus',
            'success' => true,
        ]);
    }
}
