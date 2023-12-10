<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Requests\StoreRiderRatingQuestion as StoreRiderRatingQuestionRequest;

use App\Models\RiderRatingQuestion;

class RiderRatingQuestionController extends Controller
{
    public function index()
    {
        $rider_questions = RiderRatingQuestion::query();
        $rider_questions->orderBy('id', 'DESC');
        return api_success('All Rider Rating Questions', $rider_questions->get());
    }

    public function index_active()
    {
        $rider_questions = RiderRatingQuestion::query();
        $rider_questions->whereRaw('`flags` & ?=?', [RiderRatingQuestion::FLAG_ACTIVE, RiderRatingQuestion::FLAG_ACTIVE]);
        $rider_questions->orderBy('id', 'DESC');
        return api_success('Active Rider Rating Questions', $rider_questions->get());
    }

    public function store(StoreRiderRatingQuestionRequest $request)
    {
        $rider_question = new RiderRatingQuestion;
        $rider_question->rider_rating_question_id = (String) Str::uuid();
        $rider_question->text = $request->input('text', $rider_question->text);
        $rider_question->addFlag(RiderRatingQuestion::FLAG_ACTIVE);
        if ($rider_question->save()) return api_success1('Rider Rating Question Added!');

        return api_error();
    }

    public function show(Request $request)
    {
        $rider_question = RiderRatingQuestion::where('rider_rating_question_id', $request->rider_rating_question_id)->first();
        return api_success('Rider Rating Question', ['rider_question' => $rider_question]);

        return api_error();
    }

    public function update(Request $request)
    {
        $rider_question = RiderRatingQuestion::where('rider_rating_question_id', $request->rider_rating_question_id)->first();
        $rider_question->text = $request->input('text', $rider_question->text);
        if ($request->has('status') && $request->filled('status')) {
            $rider_question->removeFlag(RiderRatingQuestion::FLAG_ACTIVE);
            if ($request->status == 'active') $rider_question->addFlag(RiderRatingQuestion::FLAG_ACTIVE);

        }
        if ($rider_question->save()) return api_success1('Rider Rating Question Updated!');

        return api_error();
    }
}
