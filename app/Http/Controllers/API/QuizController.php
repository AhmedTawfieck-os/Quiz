<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreQuizRequest;
use App\Http\Resources\QuizResource;
use App\Models\Quiz;
use App\Http\Requests\UpdateQuizRequest;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizzes=Quiz::with('task')->get(); 
        return response()->Json(['quizzes'=>QuizResource::collection($quizzes)],200);
        //
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
    public function store(StoreQuizRequest $request)
    {
        $data=$request->validated(); 
        $quiz=Quiz::create($data); 
        $quiz->load(['task']);
        return response()->Json(['message'=>"Quiz added successfully", 'Quiz'=>QuizResource::make($quiz)],200);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz)
    {
        $quiz->load(['task']);
        return response()->Json(['quiz'=>QuizResource::make($quiz)],200);
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuizRequest $request, Quiz $quiz)
    {
        $data=$request->validated(); 
        $quiz->update($data); 
        return response()->Json(['message'=>"Quiz updated successfully", 'quiz'=>QuizResource::make($quiz->load(['task']))], 200);
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return response()->Json(['message'=>"Quiz deleted successfully"], 200);
        //
    }
}
