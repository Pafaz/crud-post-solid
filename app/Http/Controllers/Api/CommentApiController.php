<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\CommentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;

class CommentApiController extends Controller
{
    private CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request)
    {
        $response =  $this->commentService->create($request->all());
        return response()->json([
            'status' => $response['status'],
            'message' => $response['message'],
            'data' => $response['data'],
        ], $response['statusCode']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $response = $this->commentService->update($id, $request->all());
        return response()->json([
            'status' => $response['status'],
            'message' => $response['message'],
            'data' => $response['data'],
        ], $response['statusCode']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->commentService->delete($id);
        return response()->json([
            'status' => $response['status'],
            'message' => $response['message']
        ], $response['statusCode']);
    }
}
