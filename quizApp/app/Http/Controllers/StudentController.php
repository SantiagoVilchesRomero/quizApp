<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\participant;
use App\Models\quiz;
use App\Models\question;
use App\Models\result;
use App\Models\User;
use App\Models\user_quiz;

class participantOperation extends Controller
{
    //participant dashboard
    public function dashboard()
    {

        $data['portal_quizs'] = quiz::select(['quizs.*'])
            ->orderBy('id', 'desc')->where('quizs.status', '1')->get()->toArray();
        return view('participant.dashboard', $data);
    }


    //quiz page
    public function quiz()
    {


        $participant_info = user_quiz::select(['user_quizs.*', 'users.name', 'quizs.title', 'quizs.quiz_date'])
            ->join('users', 'users.id', '=', 'user_quizs.user_id')
            ->join('quizs', 'user_quizs.quiz_id', '=', 'quizs.id')->orderBy('user_quizs.quiz_id', 'desc')
            ->where('user_quizs.user_id', Session::get('id'))
            ->where('user_quizs.std_status', '1')
            ->get()->toArray();

        return view('participant.quiz', ['participant_info' => $participant_info]);

    }


    //join quiz page
    public function join_quiz($id)
    {
        $quiz = quiz::where('id', $id)->first();

        $question = question::where('quiz_id', $id)->get();

        // Verifica si hay preguntas
        if ($question->isEmpty()) {
            // Puedes manejar la situación en la que no hay preguntas
            return back()->withInput()->withErrors(['message' => 'There are no questions for this quiz: ' . $quiz->title]);
        }

        return view('participant.join_quiz', ['question' => $question, 'quiz' => $quiz]);
    }



    //On submit
    public function submit_questions(Request $request)
    {


        $yes_ans = 0;
        $no_ans = 0;
        $data = $request->all();
        $result = array();
        for ($i = 1; $i <= $request->index; $i++) {

            if (isset($data['question' . $i])) {
                $q = question::where('id', $data['question' . $i])->get()->first();

                if ($q->ans == $data['ans' . $i]) {
                    $result[$data['question' . $i]] = 'YES';
                    $yes_ans++;
                } else {
                    $result[$data['question' . $i]] = 'NO';
                    $no_ans++;
                }
            }
        }

        $std_info = user_quiz::where('user_id', Session::get('id'))->where('quiz_id', $request->quiz_id)->get()->first();
        $std_info->quiz_joined = 1;
        $std_info->update();


        $res = new result();
        $res->quiz_id = $request->quiz_id;
        $res->user_id = Session::get('id');
        $res->yes_ans = $yes_ans;
        $res->no_ans = $no_ans;
        echo $res->save();
        return redirect(url('participant/quiz'));
    }



    //Applying for quiz
    public function apply_quiz($id)
    {

        $checkuser = user_quiz::where('user_id', Session::get('id'))->where('quiz_id', $id)->get()->first();

        if ($checkuser) {
            $arr = array('status' => 'false', 'message' => 'Already applied, see your quiz section');
        } else {
            $quiz_user = new user_quiz();

            $quiz_user->user_id = Session::get('id');
            $quiz_user->quiz_id = $id;
            $quiz_user->std_status = 1;
            $quiz_user->quiz_joined = 0;

            $quiz_user->save();

            $arr = array('status' => 'true', 'message' => 'applied successfully', 'reload' => url('participant/dashboard'));
        }

    }


    //View Result
    public function view_result($id)
    {

        $data['result_info'] = result::where('quiz_id', $id)->where('user_id', Session::get('id'))->get()->first();

        $data['participant_info'] = User::where('id', Session::get('id'))->get()->first();

        $data['quiz_info'] = quiz::where('id', $id)->get()->first();

        return view('participant.view_result', $data);
    }


    //View answer
    public function view_answer($id)
    {

        $data['question'] = question::where('quiz_id', $id)->get()->toArray();

        return view('participant.view_amswer', $data);
    }



}
