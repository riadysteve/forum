<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function answers() {
        return $this->hasMany(Answer::class);
    }
    
    public function votes() {
        return $this->hasMany(Vote::class);
    }

    public function upVotes() {
        return $this->votes()->where('type', 'up')->count();
    }

    public function downVotes() {
        return $this->votes()->where('type', 'down')->count();
    }

    public function voteCount() {
        return ($this->upVotes() - $this->downVotes())*10;
    }

    public function scopeVotesCount($query) {
        return $query->join('votes', 'votes.question_id', '=', 'question.id')
        ->selectRaw('questions.*, sum(votes.value) as total_vote');
    }
}