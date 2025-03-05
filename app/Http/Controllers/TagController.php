<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Interfaces\TagInterface;
use App\Services\TagService;

class TagController extends Controller
{
    protected $tagService;

    Public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagRequest $request)
    {
        // dd($request->validated());
        $this->tagService->createTag($request->validated());
        return redirect()->back()->with('success', 'Tag created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show( $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TagRequest $request,  $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $this->tagService->deleteTag($id);
        return redirect()->back()->with('success', 'Tag deleted successfully');
    }
}
