<?php

namespace App\Http\Controllers\Api;

use App\Services\PostService;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;

class PostApiController extends Controller
{
    private $postService;

    public function __construct(
        PostService $postService)
    {
        $this->postService = $postService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        return $this->postService->getPostsApi();
    }

    public function show(string $id)
    {
        return $this->postService->getPostApi($id);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {   
        return $this->postService->createPostApi($request->validated());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id)
    {
        return $this->postService->updatePostApi($id, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        return $this->postService->deletePostApi($id);
    }
}
