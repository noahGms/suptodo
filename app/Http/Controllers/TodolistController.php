<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodolistRequest;
use App\Http\Resources\TodolistResource;
use App\Models\Todolist;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class TodolistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return TodolistResource::collection(Todolist::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TodolistRequest $request
     * @return JsonResponse
     */
    public function store(TodolistRequest $request): JsonResponse
    {
        $todolist = new Todolist();
        $todolist->fill($request->validated());
        $todolist->created_by = Auth::id();
        $todolist->save();

        return response()->json(['message' => 'todolist created']);
    }

    /**
     * Display the specified resource.
     *
     * @param Todolist $todolist
     * @return TodolistResource
     */
    public function show(Todolist $todolist): TodolistResource
    {
        return TodolistResource::make($todolist);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TodolistRequest $request
     * @param Todolist $todolist
     * @return JsonResponse
     */
    public function update(TodolistRequest $request, Todolist $todolist): JsonResponse
    {
        $todolist->update($request->validated());
        return response()->json(['message' => 'todolist updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Todolist $todolist
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Todolist $todolist): JsonResponse
    {
        $todolist->delete();
        return response()->json(['message' => 'todolist deleted']);
    }
}
