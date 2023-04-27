<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Resources\QuizResource;
use App\Http\Resources\QuestionResource;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Task;
use App\Models\Question;
use App\Models\Quiz;
use App\Http\Requests\StoreAnswerRequest;
use App\Models\Answer;

class UserController extends Controller
{
    public function index()
    {
        $users=User::with('roles')->get();
        return response()->Json(['records'=>UserResource::collection($users)], 200);
    }

    public function store(StoreUserRequest $request)
    {
        $data=$request->validated(); 
        $user=User::create($data); 
        $user->assignRole('member');
        return response()->Json(['message'=>"User created successfully", 'user'=>UserResource::make($user->load(['roles']))]);
    }

    public function show(User $user)
    {
        $user->load(['roles']); 
        return response()->Json(['record'=>UserResource::make($user)]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data=$request->validated();
        $user->update($data);
        return response()->Json(['message'=>'user updated successfully', 
            'user'=>UserResource::make($user->load(['roles']))]);
    }

    public function destroy(User $user)
    {
        $user->delete(); 
        return response()->Json(['message'=>'User deleted successfully']);
    }

    public function getQuizzes()
    {
       $quizzes=Quiz::whereHas('task', function($q){
            $q->where('user_id', auth()->user()->id)->where('status', 'going');
            return $q;
       })->with('questions')->get();
       return response()->Json(['quizzes'=>QuizResource::collection($quizzes)],200);
    }

    public function getQuestions()
    {  
        $quizzes=Quiz::WhereHas('task', function($q){
            $q->where('status', 'going')->where('user_id', auth()->user()->id);
            return $q;
        })->pluck('id');
        $questions=Question::whereIn('quiz_id', $quizzes)->get();
        return response()->Json(['questions'=>QuestionResource::collection($questions)]);

        //Be noted that we did not apply nested where has by putting Question::whereHas('quizz) first
        /*
        another way of answer

        $questions=Task::where('user_id', auth()->user()->id)->
        where('status', 'going')->
        with('quizzes', function($q){
            return $q->with('questions');
        })->get();

        */
    }

    public function answerQuestion(StoreAnswerRequest $request, Question $question)
    {
        $this->authorize('answer-question', $question);
        $data=$request->validated(); 
        $data['user_id']=auth()->user()->id; 
        $data['question_id']=$question->id;
        $answer=Answer::create($data); 
        return response()->Json(['message'=>"Answer saved successfully", 'answer'=>$answer],200);
    }
}
