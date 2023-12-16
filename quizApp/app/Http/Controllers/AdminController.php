<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\quiz;
use App\Models\participant;
use App\Models\portal;
use App\Models\User;
use App\Models\question;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\user_quiz;
use App\Models\Admin;
use App\Models\result;

class AdminController extends Controller
{
    // admin dashboard
    public function index()
    {

        $user_count = User::get()->count();
        $quiz_count = quiz::get()->count();
        $admin_count = Admin::get()->count();
        return view('admin.dashboard', ['participant' => $user_count, 'quiz' => $quiz_count, 'admin' => $admin_count]);
    }


    //Manage quiz page
    public function manage_quiz()
    {
        $data['quizs'] = quiz::get()->toArray();
        return view('admin.manage_quiz', $data);
    }



    //Adding new quiz page
    public function add_new_quiz(Request $request)
    {
        $validator = Validator::make($request->all(), ['title' => 'required']);

        if ($validator->fails()) {
            $arr = array('status' => 'false', 'message' => $validator->errors()->all());
        } else {

            $quiz = new quiz();
            $quiz->title = $request->title;
            $quiz->status = 1;
            $quiz->save();

            $arr = array('status' => 'true', 'message' => 'quiz added successfully', 'reload' => url('admin/manage_quiz'));
        }
    }



    //editing quiz status
    public function quiz_status($id)
    {

        $quiz = quiz::where('id', $id)->get()->first();

        if ($quiz->status == 1)
            $status = 0;
        else
            $status = 1;

        $quiz1 = quiz::where('id', $id)->get()->first();
        $quiz1->status = $status;
        $quiz1->update();
    }



    //Deleting quiz status
    public function delete_quiz($id)
    {
        $quiz1 = quiz::where('id', $id)->get()->first();
        $quiz1->delete();
        return redirect(url('admin/manage_quiz'));
    }



    //Edit quiz
    public function edit_quiz($id)
    {
        $data['quiz'] = quiz::where('id', $id)->get()->first();

        return view('admin.edit_quiz', $data);
    }


    //Editing quiz
    public function edit_quiz_sub(Request $request)
    {

        $quiz = quiz::where('id', $request->id)->get()->first();
        $quiz->title = $request->title;

        $quiz->update();
    }

    public function edit_participants($id)
    {
        $data['participants'] = User::where('id', $id)->get()->first();
        return view('admin.edit_participants', $data);
    }


    //Manage participants
    public function manage_participants()
    {

        $data['quizs'] = quiz::where('status', '1')->get()->toArray();
        $data['participants'] = user_quiz::select(['user_quizs.*', 'users.name', 'quizs.title as ex_name', 'quizs.quiz_date'])
            ->join('users', 'users.id', '=', 'user_quizs.user_id')
            ->join('quizs', 'user_quizs.quiz_id', '=', 'quizs.id')->orderBy('user_quizs.quiz_id', 'desc')
            ->get()->toArray();
        return view('admin.manage_participants', $data);
    }



    //Add new participants
    public function add_new_participants(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'quiz' => 'required',
            'password' => 'required'

        ]);

        if ($validator->fails()) {
            $arr = array('status' => 'false', 'message' => $validator->errors()->all());
        } else {
            $std = new User();
            $std->name = $request->name;
            $std->email = $request->email;
            $std->quiz = $request->quiz;
            $std->password = Hash::make($request->password);

            $std->status = 1;

            $std->save();

            $arr = array('status' => 'true', 'message' => 'participant added successfully', 'reload' => url('admin/manage_participants'));
        }
    }



    //Editing participant status
    public function participant_status($id)
    {
        $std = user_quiz::where('id', $id)->get()->first();

        if ($std->std_status == 1)
            $status = 0;
        else
            $status = 1;

        $std1 = user_quiz::where('id', $id)->get()->first();
        $std1->std_status = $status;
        $std1->update();
    }


    //Deleting participants
    public function delete_participants($id)
    {

        $std = user_quiz::where('id', $id)->get()->first();
        $std->delete();
        return redirect('admin/manage_participants');
    }



    //Editing participants
    public function edit_participants_final(Request $request)
    {

        $std = User::where('id', $request->id)->get()->first();
        $std->name = $request->name;
        $std->email = $request->email;
        $std->quiz = $request->quiz;
        if ($request->password != '')
            $std->password = $request->password;

        $std->update();
    }




    //Registered participant page
    public function registered_participants()
    {

        $data['users'] = User::get()->all();


        return view('admin.registered_participants', $data);
    }


    //Deleting participants egistered
    public function delete_registered_participants($id)
    {

        $std = User::where('id', $id)->get()->first();
        $std->delete();
        return redirect('admin/registered_participants');

    }




    //addning questions
    public function add_questions($id)
    {

        $data['questions'] = question::where('quiz_id', $id)->get()->toArray();
        return view('admin.add_questions', $data);
    }


    //adding new questions
    public function add_new_question(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'question' => 'required',
            'option_1' => 'required',
            'option_2' => 'required',
            'option_3' => 'required',
            'option_4' => 'required',
            'ans' => 'required'
        ]);

        if ($validator->fails()) {
            $arr = array('status' => 'flase', 'message' => $validator->errors()->all());

        } else {

            $q = new question();
            $q->quiz_id = $request->quiz_id;
            $q->questions = $request->question;

            if ($request->ans == 'option_1') {
                $q->ans = $request->option_1;
            } elseif ($request->ans == 'option_2') {
                $q->ans = $request->option_2;
            } elseif ($request->ans == 'option_3') {
                $q->ans = $request->option_3;
            } else {
                $q->ans = $request->option_4;
            }



            $q->status = 1;
            $q->save();

            $arr = array('status' => 'true', 'message' => 'successfully added', 'reload' => url('admin/add_questions/' . $request->quiz_id));
        }
    }



    //Edit question status
    public function question_status($id)
    {
        $p = question::where('id', $id)->get()->first();

        if ($p->status == 1)
            $status = 0;
        else
            $status = 1;

        $p1 = question::where('id', $id)->get()->first();
        $p1->status = $status;
        $p1->update();
    }


    //Delete questions
    public function delete_question($id)
    {

        $q = question::where('id', $id)->get()->first();
        $quiz_id = $q->quiz_id;
        $q->delete();

        return redirect(url('admin/add_questions/' . $quiz_id));
    }



    //update questions
    public function update_question($id)
    {

        $data['q'] = question::where('id', $id)->get()->toArray();

        return view('admin.update_question', $data);
    }


    //Edit question
    public function edit_question_inner(Request $request)
    {

        $q = question::where('id', $request->id)->get()->first();

        $q->questions = $request->question;

        if ($request->ans == 'option_1') {
            $q->ans = $request->option_1;
        } elseif ($request->ans == 'option_2') {
            $q->ans = $request->option_2;
        } elseif ($request->ans == 'option_3') {
            $q->ans = $request->option_3;
        } else {
            $q->ans = $request->option_4;
        }
        $q->update();
    }


    public function admin_view_result($id)
    {

        $std_quiz = user_quiz::where('id', $id)->get()->first();

        $data['participant_info'] = User::where('id', $std_quiz->user_id)->get()->first();

        $data['quiz_info'] = quiz::where('id', $std_quiz->quiz_id)->get()->first();

        $data['result_info'] = result::where('quiz_id', $std_quiz->quiz_id)->where('user_id', $std_quiz->user_id)->get()->first();

        return view('admin.admin_view_result', $data);


    }
}
