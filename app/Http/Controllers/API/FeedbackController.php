<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FeedbackService;

class FeedbackController extends Controller
{
    public function viewFeedback($attendance_id) {
        $service = new FeedbackService;
        $feedback = $service->viewFeedback($attendance_id);
        if($feedback['status'] == 'success') {
            return response()->json([
                'status' => $feedback['status'],
                'message' => $feedback['message'],
                'first_question' => $feedback['first_question'],
                'second_question' => $feedback['second_question'],
                'third_question' => $feedback['third_question'],
                'first_question_average' => $feedback['first_question_average'],
                'second_question_average' => $feedback['second_question_average'],
                'third_question_average' => $feedback['third_question_average'],
                'feedback_filled_by' => $feedback['feedback_filled_by'],
                'total_students' => $feedback['total_students'],
            ]);
        } else {
            return response()->json([
                'status' => $feedback['status'],
                'message' => $feedback['message'],
            ]);
        }
    }

    public function addFeedbackPermission($attendance_id) {
        $service = new FeedbackService;
        $feedback = $service->addFeedbackPermission($attendance_id);
        if($feedback['status'] == 'success') {
            return response()->json([
                'status' => $feedback['status'],
                'message' => $feedback['message'],
            ]);
        } else {
            return response()->json([
                'status' => $feedback['status'],
                'message' => $feedback['message'],
            ]);
        }
    }

    public function addFeedback(Request $request,$attendance_id) {
        $service = new FeedbackService;
        $feedback = $service->addFeedback($request,$attendance_id);
        if($feedback['status'] == 'success') {
            return response()->json([
                'status' => $feedback['status'],
                'message' => $feedback['message'],
                'data' => $feedback['data'],
            ]);
        } else {
            return response()->json([
                'status' => $feedback['status'],
                'message' => $feedback['message'],
            ]);
        }
    }

    public function getQuestions() {
        $service = new FeedbackService;
        $feedback = $service->getQuestions();
        if($feedback['status'] == 'success') {
            return response()->json([
                'status' => $feedback['status'],
                'message' => $feedback['message'],
                'data' => $feedback['data'],
            ]);
        } else {
            return response()->json([
                'status' => $feedback['status'],
                'message' => $feedback['message'],
            ]);
        }
    }

    public function getTeacherProfilePic($attendance_id) {
        $service = new FeedbackService;
        $feedback = $service->getTeacherProfilePic($attendance_id);
        // if($feedback['status'] == 'success') {
            return response()->json([
                'status' => $feedback['status'],
                'message' => $feedback['message'],
                'data' => $feedback['data'],
            ]);
        // } else {
        //     return response()->json([
        //         'status' => $feedback['status'],
        //         'message' => $feedback['message'],
        //     ]);
        // }
    }
}
