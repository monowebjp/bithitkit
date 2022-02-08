<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreBlogArticleRequest;
use App\Http\Requests\UpdateBlogArticleRequest;
use App\Models\BlogArticle;

class BlogArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index()
    {
        // 問題なければjsonで結果を返す
        return response()->json([
            'success' => true,
            'message' => 'List Success!',
            'details' => BlogArticle::all()
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
     * @param  \App\Http\Requests\StoreBlogArticleRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreBlogArticleRequest $request)
    {
        //バリデーションルールを設定
        $validator = \Validator::make($request->all(), [
            'title' => 'required|max:255',
            'content' => 'required|max:255',
        ]);

        //バリデーションルールにでエラーの場合
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Insert Failed',
                'details' => $validator->errors()
            ]);

        }
        // 問題なければDB登録
        BlogArticle::create($request->all());
        // jsonで結果を返す
        return response()->json([
            'success' => true,
            'message' => 'Insert Success!',
            'details' => $request->all()
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BlogArticle  $blogArticle
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(BlogArticle $id)
    {
        // 存在しないレコードIDだったら
        if (BlogArticle::where('id', $id)->exists() == false ) {
            return response()->json([
                'success' => false,
                'message' => 'Show failed...',
                'details' => 'Invalid ID'
            ]);
        }
        // 問題なければjsonで結果を返す
        return response()->json([
            'success' => true,
            'message' => 'Show Success!',
            'details' => BlogArticle::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BlogArticle  $blogArticle
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogArticle $blogArticle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBlogArticleRequest  $request
     * @param  \App\Models\BlogArticle  $blogArticle
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateBlogArticleRequest $request, $id)
    {
        //バリデーションルールを設定
        $request['id'] = $id;
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:memos',
            'title' => 'required|max:255',
            'content' => 'required|max:255',
        ]);
        //バリデーションルールにでエラーの場合
        if ($validator->fails() ) {
            return response()->json([
                'success' => false,
                'message' => 'Update failed...',
                'details' => $validator->errors()
            ]);
        }
        // 問題なければDB更新
        $memo = BlogArticle::find($id);
        $memo->update($request->all());
        // jsonで結果を返す
        return response()->json([
            'success' => true,
            'message' => 'Update Success!',
            'details' => $request->all()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BlogArticle  $blogArticle
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {

        // 存在しないレコードIDだったら
        if (BlogArticle::where('id', $id)->exists() == false ) {
            return response()->json([
                'success' => false,
                'message' => 'Delete failed...',
                'details' => 'Invalid ID'
            ]);
        }
        // 問題なければDB更新
        $memo = BlogArticle::find($id);
        $memo->delete();
        // jsonで結果を返す
        return response()->json([
            'success' => true,
            'message' => 'Delete Success!',
            'details' => $memo
        ]);
    }
}
