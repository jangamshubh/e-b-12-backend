<?php

namespace App\Services;

use Auth;
use App\Models\Feedback;
use App\Models\Question;
use App\Models\Attendance;
use App\Models\AttendanceBatch;
use App\Models\BatchStudent;
use DB;
class FeedbackService {

    public function viewFeedback($attendance_id) {
        if(Auth::user()->hasRole('Teacher')) {
            $teacher_id = Attendance::where('id',$attendance_id)->pluck('added_by')->first();
            if($teacher_id == Auth::id()) {
                $feedback = Feedback::where('attendance_id',$attendance_id)->get();
                $first_question = Question::where('id',1)->first();
                $second_question = Question::where('id',2)->first();
                $third_question = Question::where('id',3)->first();
                $first_question_average = Feedback::where('attendance_id',$attendance_id)->where('question_id',1)->average('feedback');
                $second_question_average = Feedback::where('attendance_id',$attendance_id)->where('question_id',2)->average('feedback');
                $third_question_average = Feedback::where('attendance_id',$attendance_id)->where('question_id',3)->average('feedback');
                $batches = AttendanceBatch::where('attendance_id',$attendance_id)->pluck('batch_id')->toArray();
                $total_students = BatchStudent::whereIn('batch_id',$batches)->count();
                $feedback_filled_by = $feedback->unique('student_id')->count();
                $data['first_question'] = $first_question;
                $data['second_question'] = $second_question;
                $data['third_question'] = $third_question;
                $data['first_question_average'] = $first_question_average;
                $data['second_question_average'] = $second_question_average;
                $data['third_question_average'] = $third_question_average;
                $data['feedback_filled_by'] = $feedback_filled_by;
                $data['total_students'] = $total_students;
                $data['message'] = 'Feedback Retrieved Successfully';
                $data['status'] = 'success';
                return $data;
            }
        }
    }

    public function addFeedbackPermission($attendance_id) {
        if(Auth::user()->hasRole('Student')) {
            $filled_feedback = Feedback::where('attendance_id',$attendance_id)->where('student_id',Auth::id())->count();
            if($filled_feedback == 0) {
                $data['status'] = 'success';
                $data['message'] = 'Permission success';
                return $data;
            } else {
                $data['status'] = 'error';
                $data['message'] = 'Permission error';
                return $data;
            }
        }
    }

    public function addFeedback($request,$attendance_id) {
        if(Auth::user()->hasRole('Student')) {
            $data = $this->addFeedbackPermission($attendance_id);
            if($data['status'] == 'success') {
                $feedback = $request->student_feedback;
                for($i = 0; $i < count($feedback); $i++) {
                    $student_feedback = new Feedback;
                    $student_feedback->attendance_id = $attendance_id;
                    $student_feedback->student_id = Auth::id();
                    $student_feedback->question_id = $feedback[$i]['question_id'];
                    $student_feedback->feedback = $feedback[$i]['feedback'];
                    $student_feedback->save();
                }
                $data['status'] = 'success';
                $data['message'] = 'Feedback Successfully Added';
                $data['data'] = $student_feedback;
                return $data;
            } else {
                $data['status'] = 'error';
                $data['message'] = 'Feedback Cannot be added, contact admin';
                return $data;
            }
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Feedback Cannot be added, contact admin';
            return $data;
        }
    }

    public function getQuestions() {
        if(Auth::user()->hasRole('Student')) {
            $questions = Question::all();
            $data['data'] = $questions;
            $data['message'] = 'Questions Retrieved Successfully';
            $data['status'] = 'success';
            return $data;
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Feedback Cannot be added, contact admin';
            return $data;
        }
    }
}
