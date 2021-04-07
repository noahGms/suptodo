<?php

namespace App\Http\Controllers;

use App\Mail\NotificationMail;
use App\Models\User;
use Exception;
use App\Models\Todolist;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TodolistRequest;
use App\Http\Resources\TodolistResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Mail;
use phpDocumentor\Reflection\Types\Collection;

class TodolistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        if ($searchQuery = $request->query('search')) {
            $todolists = Todolist::query()->where('name', 'LIKE', '%'.$searchQuery.'%')->get();
        } else {
            $todolists = Todolist::all();
        }

        return TodolistResource::collection($todolists);
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function all(Request $request): AnonymousResourceCollection
    {
        if ($searchQuery = $request->query('search')) {
            $userId = Auth::id();
            $myTodolist = Todolist::where(function ($query) use ($userId, $searchQuery) {
                $query->where('created_by', $userId)
                    ->where('name', 'LIKE', '%'.$searchQuery.'%');
            })->get();
            $todolistsInvited = Auth::user()->TodolistsAccepted()->where('name', 'LIKE', '%'.$searchQuery.'%')->get();
        } else {
            $myTodolist = Todolist::where('created_by', Auth::id())->get();
            $todolistsInvited = Auth::user()->TodolistsAccepted;
        }

        $todolists = $myTodolist->merge($todolistsInvited);

        return TodolistResource::collection($todolists);
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

        //$todolist->Participants()->attach(Auth::user());
        $todolist->Participants()->attach($request->participants);

        $this->sendMail($request->participants, $todolist);

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

        $todolist->Participants()->sync($request->participants);

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

    /**
     * @return AnonymousResourceCollection
     */
    public function invitations(): AnonymousResourceCollection
    {
        return TodolistResource::collection(Auth::user()->TodolistInvitations()->get());
    }

    /**
     * @param Todolist $todolist
     * @return JsonResponse
     */
    public function acceptParticipant(Todolist $todolist): JsonResponse
    {
        $participant = $todolist->Participants()->where('user_id', Auth::id())->first();
        if ($participant->pivot->accepted !== null) {
            return response()->json(['message' => 'an error are occured']);
        }
        $participant->pivot->accepted = true;
        $participant->pivot->update();
        return response()->json(['message' => 'invitation accepted']);
    }

    /**
     * @param Todolist $todolist
     * @return JsonResponse
     */
    public function denyParticipant(Todolist $todolist): JsonResponse
    {
        $participant = $todolist->Participants()->where('user_id', Auth::id())->first();
        if ($participant->pivot->accepted !== null) {
            return response()->json(['message' => 'an error are occured']);
        }
        $participant->pivot->accepted = false;
        $participant->pivot->update();
        return response()->json(['message' => 'invitation denied']);
    }

    /**
     * @param $participants
     * @param $todolist
     */
    private function sendMail($participants, $todolist)
    {
        if (!empty($participants)) {
            foreach ($participants as $participant) {
                $user = User::where('id', $participant)->first();
                $details = [
                    'title' => 'Todolist invitation request',
                    'body' => $user->username . ' add you on todolist ' . $todolist->id . ' !'
                ];
                Mail::to(Auth::user()->email)->send(new NotificationMail($details));
            }
        }
    }
}
