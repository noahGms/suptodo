<?php

namespace App\Http\Controllers;

use App\Http\Requests\FriendRequest;
use App\Http\Resources\FriendResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return FriendResource::collection(Auth::user()->Friends);
    }

    /**
     * @param FriendRequest $request
     * @return JsonResponse
     */
    public function add(FriendRequest $request): JsonResponse
    {
        Auth::user()->Friends()->attach($request->validated());
        return response()->json(['message' => 'friend invited']);
    }

    /**
     * @param User $friend
     * @return JsonResponse
     */
    public function remove(User $friend): JsonResponse
    {
        Auth::user()->Friends()->detach($friend->id);
        return response()->json(['message' => 'friend removed']);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function invitations(): AnonymousResourceCollection
    {
        return FriendResource::collection(Auth::user()->Invitations()->get());
    }

    /**
     * @param User $user
     */
    public function accept(User $user): JsonResponse
    {
        if ($user->Friends()->find(Auth::user())->pivot->accepted !== null) {
            return response()->json(['message' => 'an error are occurred']);
        }
        $user->Friends()->updateExistingPivot(Auth::user(), ['accepted' => true]);
        return response()->json(['message' => 'invitation accepted']);
    }

    /**
     * @param User $user
     */
    public function deny(User $user): JsonResponse
    {
        if ($user->Friends()->find(Auth::user())->pivot->accepted !== null) {
            return response()->json(['message' => 'an error are occurred']);
        }
        $user->Friends()->updateExistingPivot(Auth::user(), ['accepted' => false]);
        return response()->json(['message' => 'invitation denied']);
    }
}
