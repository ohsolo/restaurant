<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupportQuestionRequest;
use App\Models\SupportQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SupportQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $support_questions = SupportQuestion::orderBy('created_at', 'desc')->get();
        if ($support_questions) return api_success_app($support_questions);
        return api_error_app();
    }

    public function index_admin()
    {
        $support_questions = SupportQuestion::orderBy('created_at', 'desc')->paginate(10);
        return api_success('All Support Questions', ['support_questions' => $support_questions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        //
    }
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupportQuestionRequest $request)
    {
        $support_question = new SupportQuestion;
        $support_question->support_question_id = Str::uuid();
        $support_question->question = $request->question;
        $support_question->addFlag(SupportQuestion::FLAG_STATUS_ACTIVE);
        if ($support_question->save()) return api_success1('Support Question Added Successfully');
        return api_error();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SupportQuestion  $supportQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = SupportQuestion::where('support_question_id', $id)->delete();

        if ($result) return api_success1('Support Question Deleted Successfully');
        return api_error();
    }
}
