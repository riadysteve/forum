<?php

namespace App\Http\Controllers;

use App\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function upvote($id) {
        // dd(Vote::all()->where('question_id', $id)->where('type', 'up')->where('user_id', Auth::id())->first());
        if(Auth::check()) {
            if (!(Vote::all()->where('question_id', $id)->where('type', 'up')->where('user_id', Auth::id())->isEmpty())) {
                $vote = Vote::all()->where('question_id', $id)->where('type', 'up')->where('user_id', Auth::id())->first();
                $vote->delete(); 

                return back()->with('success', 'Thanks for removing your downvote');
            } 
            if(Vote::all()->where('question_id', $id)->where('type', 'up')->where('user_id', Auth::id())->isEmpty()) {
                Vote::create([
                    'type' => 'up',
                    'question_id' => $id,
                    'user_id' => Auth::id(),
                ]);

                return back()->with('success', 'You Up Vote this question!');
            }
        } else {
            return route('login');
        }
    }
    
    // public function downvote($id) {
    //     // dd(Vote::all()->where('question_id', $id)->where('type', 'down')->where('user_id', Auth::id()));
    //     if(Auth::check()) {
    //         if (!(Vote::all()->where('question_id', $id)->where('type', 'down')->where('user_id', Auth::id())->isEmpty())) {
    //             $vote = Vote::all()->where('type', 'down')->where('user_id', Auth::id())->first();
    //             $vote->delete();

    //             return back()->with('success', 'You remove you downvote');
    //         } 
    //         if(Vote::all()->where('question_id', $id)->where('type', 'down')->where('user_id', Auth::id())->isEmpty()){
    //             Vote::create([
    //                 'type' => 'down',
    //                 'question_id' => $id,
    //                 'user_id' => Auth::id(),
    //             ]);

    //             return back()->with('success', 'You downvote this question');
    //         }
    //     }
    //     else {
    //         return route('login');
    //     }
    // }
}