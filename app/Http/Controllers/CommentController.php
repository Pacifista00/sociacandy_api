<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    public function store($postId, Request $request){
        $request->validate([
            'content' => ['required']
        ]);

        Comment::create([
            'content' => $request->content,
            'user_id' => Auth::user()->id,
            'post_id' => $postId,
        ]);

        return response()->json([
            'message' => 'Comment ditambahkan!'
        ]);
    }

    public function show($id){
        $comment = Comment::findOrFail($id);
        return response()->json([
            'data' => new CommentResource($comment)
        ]);
    }

    public function update($id, Request $request){
        $comment = Comment::findOrFail($id);

        if($comment->user_id != Auth::user()->id){
            return response()->json([
                'message' => 'Update gagal!'
            ]);
        }

        $request->validate([
            'content' => ['required']
        ]);

        $comment->update([
            'content' => $request->content
        ]);

        return response()->json([
            'message' => 'Update Success!'
        ]);
    }
    public function destroy($id){
        $comment = Comment::findOrfail($id);
        if($comment->user_id != Auth::user()->id){
            return response()->json([
                'message' => 'Anda bukan pemilik comment!'
            ]);
        }

        $comment->delete();
        return response()->json([
            'message' => 'Comment berhasil dihapus!'
        ]);
    }
}
