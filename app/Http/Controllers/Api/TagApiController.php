<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TagRequest;
use App\Services\TagService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagApiController extends Controller
{
    private TagService $tagService;

    public function __construct(TagService $tagService) {
        $this->tagService = $tagService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->tagService->getTagsApi();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagRequest $request)
    {
        return $this->tagService->createTagApi($request->validated());
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->tagService->deleteTagApi($id);
    }
}
