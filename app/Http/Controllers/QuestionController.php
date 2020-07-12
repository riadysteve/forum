<?php

namespace App\Http\Controllers;

use App\Question;
use App\Vote;
use App\User;
use Illuminate\Support\Facades\Auth;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index() {
        $questions = Question::orderBy('created_at', 'DESC')->paginate(5);
        // $user = User::findOrFail(Auth::id());
        $vote = Vote::all();

        return view('home', compact('questions', 'vote'));
    }

    public function create() {
        return view('question.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required'
        ]); 

        $id = auth()->user()->questions()->create([
            'title' => $request->title,
            'tag' => $request->tag,
            'content' => $request->content
        ])->id;

        return redirect()->route('question.show', $id)->with('success', 'Question succesfully added');
    }

    public function show($id) {
        $question = Question::findOrFail($id);
        // $user = User::findOrFail(auth()->user()->id);
        $answers = Question::find($id)->answers;
        $vote = Vote::all();
        
        return view('question.show', compact('question', 'answers', 'vote'));
    }

    public function edit($id) {
        $question = Question::findOrFail($id);
        $user = User::findOrFail(Auth::id());
        $this->authorize('update', $question);

        return view('question.edit', compact('question', 'user'));
    }

    public function update($id, Request $request) {
        $question = Question::findOrFail($id);
        $this->authorize('update', $question);

        $this->validate($request, [
            'title' => 'required',
            'content' => 'required'
        ]);

        $question->update([
            'title' => $request->title,
            'tag' => $request->tag,
            'content' => $request->content
        ]);

        return redirect()->route('question.show', $id)->with('success', 'Question Edited Successfully');
    }

    public function destroy($id) {
        // dd($id);
        // $question = Question::findOrFail($id)->answers()->delete();
        $question = Question::findOrFail($id)->delete();
        // $this->authorize('delete', $question);

        return redirect()->route('profile.index', auth()->user()->id)->with('success', 'Your Question Deleted Successfully');
    }
}