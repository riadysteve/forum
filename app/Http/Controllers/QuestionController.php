<?php

namespace App\Http\Controllers;

use App\Question;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index() {
        $questions = Question::orderBy('created_at', 'DESC')->paginate(2);
        $user = User::findOrFail(Auth::id());

        return view('home', compact('questions', 'user'));
    }

    public function create() {
        return view('question.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required'
        ]);

        auth()->user()->questions()->create([
            'title' => $request->title,
            'tag' => $request->tag,
            'content' => $request->content
        ]);

        return redirect()->route('profile.index', auth()->user()->id)->with('success', 'Question succesfully added');
    }

    public function show($id) {
        $question = Question::findOrFail($id);
        $user = User::findOrFail(auth()->user()->id);
        
        return view('question.show', compact('question', 'user'));
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

        return redirect()->route('profile.index', auth()->user()->id)->with('success', 'Question Edited Successfully');
    }

    public function destroy($id) {
        $question = Question::findOrFail($id)->delete();

        return redirect()->route('profile.index', auth()->user()->id)->with('success', 'Your Question Deleted Successfully');
    }
}