<?php

namespace App\Http\Controllers;

use App\Question;
use App\User;
use App\Answer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function store(Request $request, $id) {
        $this->validate($request, [
            'answer' => 'required',
        ]);

        auth()->user()->answers()->create([
            'answer' => $request->answer,
            'user_id' => Auth::user()->id,
            'question_id' => $id
        ]);

        return redirect()->back()->with('success', 'Your Answer Post Successfully');
    }

    public function edit($id) {
        $answer = Answer::findOrFail($id);
        $user = User::findOrFail(Auth::id());
        // dd($user);

        return view('answer.edit', compact('answer', 'user'));
    }

    public function update($id, Request $request) {
        $answer = Answer::findOrFail($id);
        $this->authorize('update', $answer);

        $this->validate($request, [
            'answer' => 'required'
        ]);

        $answer->update([
            'answer' => $request->answer
        ]);

        return redirect()->route('question.show', $answer->question_id)->with('success', 'Answer Edited Successfully');
    }

    public function destroy($id) {
        $answer = Answer::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Comment Deleted Successfully');
    }
}