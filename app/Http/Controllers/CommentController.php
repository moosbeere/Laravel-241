<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Mail\Commentmail;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;



class CommentController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'text'=>'min:10|required',
        ]);

        $comment = new Comment;
        $comment-> text = $request->text;
        $comment->article_id = $request->article_id;
        $comment->user_id = auth()->id();
        if($comment->save())
            Mail::to('moosbeere_O@mail.ru')->send(new Commentmail($comment, $request->article_id));
        return redirect()->route('article.show', $request->article_id)->with('message', "Comment add succesful");
    }

    public function edit(Comment $comment){
        Gate::authorize('comment', $comment);
    }
    public function update(Comment $comment){
        Gate::authorize('comment', $comment);
        return 0;
    }

    public function delete(Comment $comment){
        Gate::authorize('comment', $comment);
        return 0;
    }
}
