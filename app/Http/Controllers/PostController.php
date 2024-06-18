<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Notifications\PostApproved;

class PostController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(Request $request)
    {
        $posts = Post::get();

        return view('posts', compact('posts'));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function store(Request $request)
    {
        $this->validate($request, [
             'title' => 'required',
             'body' => 'required'
        ]);
   
        $post = Post::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'body' => $request->body
        ]);
   
        return back()->with('success','Post created successfully.');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function approve(Request $request, $id)
    {
        if (!auth()->user()->is_admin) {
            return back()->with('success', 'you are not super admin.');
        }

        $post = Post::find($id);

        if ($post && !$post->is_approved) {
            $post->is_approved = true;
            $post->save();

            // Notify the user
            $post->user->notify(new PostApproved($post));

            return back()->with('success','Post approved and user notified.');
        }

        return back()->with('success', 'Post not found or already approved.');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function markAsRead(Request $request, $id)
    {
        $notification = auth()->user()->unreadNotifications->find($id);
        $notification->markAsRead();

        return back()->with('success', 'Added Mark as read.');
    }
}
