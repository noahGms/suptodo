<?php

namespace App\Http\Controllers;

use App\Http\Requests\FriendRequest;
use App\Http\Resources\FriendResource;
use App\Mail\NotificationMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class FriendController extends Controller
{
    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        if ($searchQuery = $request->query('search')) {
            $friends = Auth::user()->Friends()->where(function ($query) use ($searchQuery) {
                $query->where('username', 'LIKE', '%'.$searchQuery.'%')
                    ->orWhere('email', 'LIKE', '%'.$searchQuery.'%');
            })->get();
        } else {
            $friends = Auth::user()->Friends;
        }
        return FriendResource::collection($friends);
    }

    /**
     * @param FriendRequest $request
     * @return JsonResponse
     */
    public function add(FriendRequest $request): JsonResponse
    {
        Auth::user()->Friends()->attach($request->validated());
        $user = User::where('id', $request->user_id)->first();
        $details = [
            'title' => 'Friend request',
            'body' => $user->username . ' want to be your friend !'
        ];
        Mail::to(Auth::user()->email)->send(new NotificationMail($details));
        return response()->json(['message' => 'friend invited']);
    }

    /**
     * @param User $friend
     * @return JsonResponse
     */
    public function remove(User $friend): JsonResponse
    {
        Auth::user()->Friends()->detach($friend);
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
