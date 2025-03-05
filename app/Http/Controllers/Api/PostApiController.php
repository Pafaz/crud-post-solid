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
        $response = $this->postService->getPosts();
        return response()->json([
            'status' => $response['status'],
            'message' => $response['message'],
            'data' => PostResource::collection($response['data']),
        ], $response['statusCode']);
    }

    public function show(string $id)
    {
        $response = $this->postService->getPost($id);
        return response()->json([
            'status' => $response['status'],
            'message' => $response['message'],
            'data' => $response['data'],
        ], $response['statusCode']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {   
        $response = $this->postService->create($request->validated());
        return response()->json([
            'status' => $response['status'],
            'message' => $response['message'],
            'data' => $response['data'],
        ], $response['statusCode']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id)
    {
        $response = $this->postService->update($id, $request->validated());
        return response()->json([
                'status' => $response['status'],
                'message' => $response['message'],
                'data' => $response['data'],
            ], $response['statusCode']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $response = $this->postService->delete($id);
        return response()->json([
            'status' => $response['status'],
            'message' => $response['message'],
        ], $response['statusCode']);
    }
}
