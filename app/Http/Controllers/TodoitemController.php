<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoitemRequest;
use App\Http\Resources\TodoitemResource;
use App\Models\Todoitem;
use App\Models\Todolist;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TodoitemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Todolist $todolist
     * @return AnonymousResourceCollection
     */
    public function index(Todolist $todolist): AnonymousResourceCollection
    {
        return TodoitemResource::collection(Todoitem::all()->where('todolist_id', '=', $todolist->id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TodoitemRequest $request
     * @param Todolist $todolist
     * @return JsonResponse
     */
    public function store(TodoitemRequest $request, Todolist $todolist): JsonResponse
    {
        $todoitem = new Todoitem();
        $todoitem->fill($request->validated());
        $todoitem->todolist_id = $todolist->id;
        $todoitem->save();

        return response()->json(['message' => 'todoitem created']);
    }

    /**
     * Display the specified resource.
     *
     * @param Todolist $todolist
     * @param Todoitem $item
     * @return TodoitemResource
     */
    public function show(Todolist $todolist, Todoitem $item): TodoitemResource
    {
        return TodoitemResource::make($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TodoitemRequest $request
     * @param Todolist $todolist
     * @param Todoitem $item
     * @return JsonResponse
     */
    public function update(TodoitemRequest $request, Todolist $todolist, Todoitem $item): JsonResponse
    {
        $item->update($request->validated());
        return response()->json(['message' => 'todoitem updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Todolist $todolist
     * @param Todoitem $item
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Todolist $todolist, Todoitem $item): JsonResponse
    {
        $item->delete();
        return response()->json(['message' => 'todoitem deleted']);
    }

    /**
     * @param Todolist $todolist
     * @param Todoitem $item
     * @return JsonResponse
     */
    public function changeStatus(Todolist $todolist, Todoitem $item): JsonResponse
    {
        $item->completed = !$item->completed;
        $item->save();
        return response()->json(['message' => 'todoitem status changed']);
    }

    /**
     * @param Todolist $todolist
     * @return JsonResponse
     */
    public function completeAll(Todolist $todolist): JsonResponse
    {
        // TODO: return error if todoitems if null
        $todoitems = Todoitem::where(function ($query) use ($todolist) {
            $query->where('todolist_id', $todolist->id)
                ->where('completed', 0);
        })->get();
        foreach ($todoitems as $todoitem) {
            $todoitem->completed = true;
            $todoitem->save();
        }
        return response()->json(['message' => 'all todo items completed']);
    }

    /**
     * @param Todolist $todolist
     * @return JsonResponse
     */
    public function incompleteAll(Todolist $todolist): JsonResponse
    {
        // TODO: return error if todoitems if null
        $todoitems = Todoitem::where(function ($query) use ($todolist) {
            $query->where('todolist_id', $todolist->id)
                ->where('completed', 1);
        })->get();
        foreach ($todoitems as $todoitem) {
            $todoitem->completed = false;
            $todoitem->save();
        }
        return response()->json(['message' => 'all todo items incomplete']);
    }

    /**
     * @param Todolist $todolist
     * @return JsonResponse
     */
    public function removeAllCompleted(Todolist $todolist): JsonResponse
    {
        // TODO: return error if todoitems if null
        $todoitems = Todoitem::where(function ($query) use ($todolist) {
            $query->where('todolist_id', $todolist->id)
                ->where('completed', 1);
        })->get();
        foreach ($todoitems as $todoitem) {
            $todoitem->delete();
        }
        return response()->json(['message' => 'removed all todo items completed']);
    }

}
