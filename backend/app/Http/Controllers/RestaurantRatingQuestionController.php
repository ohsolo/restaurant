<?php

namespace App\Http\Controllers;

use App\Models\RestaurantRatingQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Requests\StoreRestaurantRatingQuestion as StoreRestaurantRatingQuestionRequest;

class RestaurantRatingQuestionController extends Controller
{
    public function index()
    {
        $restaurant_question = RestaurantRatingQuestion::query();
        $restaurant_question->orderBy('id', 'DESC');
        return api_success('All Restaurant Rating Questions', $restaurant_question->get());
    }

    public function index_active()
    {
        $restaurant_question = RestaurantRatingQuestion::query();
        $restaurant_question->whereRaw('`flags` & ?=?', [RestaurantRatingQuestion::FLAG_ACTIVE, RestaurantRatingQuestion::FLAG_ACTIVE]);
        $restaurant_question->orderBy('id', 'DESC');
        return api_success_app($restaurant_question->get());
    }

    public function store(StoreRestaurantRatingQuestionRequest $request)
    {
        $restaurant_question = new RestaurantRatingQuestion;
        $restaurant_question->restaurant_rating_question_id = (string) Str::uuid();
        $restaurant_question->text = $request->input('text', $restaurant_question->text);
        $restaurant_question->addFlag(RestaurantRatingQuestion::FLAG_ACTIVE);
        if ($restaurant_question->save()) return api_success1('restaurant Rating Question Added!');

        return api_error();
    }

    public function show(Request $request)
    {
        $restaurant_question = RestaurantRatingQuestion::where('restaurant_rating_question_id', $request->restaurant_rating_question_id)->first();
        return api_success('Restaurant Rating Question', ['rest$restaurant_question' => $restaurant_question]);

        return api_error();
    }

    public function update(Request $request)
    {
        $restaurant_question = RestaurantRatingQuestion::where('restaurant_rating_question_id', $request->restaurant_rating_question_id)->first();
        $restaurant_question->text = $request->input('text', $restaurant_question->text);
        if ($request->has('status') && $request->filled('status')) {
            $restaurant_question->removeFlag(RestaurantRatingQuestion::FLAG_ACTIVE);
            if ($request->status == 'active') $restaurant_question->addFlag(RestaurantRatingQuestion::FLAG_ACTIVE);

        }
        if ($restaurant_question->save()) return api_success1('Restaurant Rating Question Updated!');
        return api_error();
    }
    public function destroy(RestaurantRatingQuestion $id)
    {
        if ($id->delete()) return api_success1('Restaurant Rating Question Deleted!');
    }
}
