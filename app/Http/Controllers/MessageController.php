<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Celebrity;
use App\Models\Message;

class MessageController extends Controller
{
    protected Celebrity $celebrity;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $slug = $request->route('celebrity');
            $this->celebrity = Celebrity::where('slug', $slug)->firstOrFail();
            view()->share('celebrity', $this->celebrity);

            return $next($request);
        });
    }

    public function index()
    {
        $user = auth()->user();
        // Show conversation threads (parent messages) for this fan + celebrity
        $threads = Message::where('celebrity_id', $this->celebrity->id)
            ->whereNull('parent_id')
            ->where(function ($q) use ($user) {
                $q->where('sender_id', $user->id)
                  ->orWhere('receiver_id', $user->id);
            })
            ->with(['sender', 'replies.sender'])
            ->latest()
            ->get();

        return view('celebrity.messages', compact('threads'));
    }

    public function store()
    {
        request()->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $user = auth()->user();

        $parentId = request('parent_id');
        $receiverId = null;

        if ($parentId) {
            $parent = Message::find($parentId);
            $receiverId = $parent && $parent->sender_id !== $user->id
                ? $parent->sender_id
                : null;
        }

        $message = Message::create([
            'celebrity_id' => $this->celebrity->id,
            'sender_id' => $user->id,
            'receiver_id' => $receiverId,
            'parent_id' => $parentId ?: null,
            'subject' => request('subject'),
            'content' => request('content'),
        ]);

        safe_event(new MessageSent($message));

        return redirect()->route('celebrity.messages', ['celebrity' => $this->celebrity->slug])
            ->with('success', 'Message sent!');
    }
}
