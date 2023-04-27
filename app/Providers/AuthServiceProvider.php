<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use App\Models\Question;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('answer-question', function(User $user, Question $question){
            //get task of the question first
            $taskIdOfQuestion= $question->quiz->task->id;
            //find if the task id is of status going
            $checkTaskStatus=$question->quiz->task()->where('status', 'going')->exists();
            //get all the tasks id assigned to user
            $userTasksId=auth()->user()->tasks->pluck('id')->toArray();
             //find out if the task of the question belongs to user tasks
            if($checkTaskStatus && in_array($taskIdOfQuestion, $userTasksId)){
                return true;
            }
            return false;
        });
        //
    }
}
