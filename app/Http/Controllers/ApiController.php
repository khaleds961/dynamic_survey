<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Participant;
use App\Models\Response;
use Illuminate\Http\Request;
use App\Models\Survey;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class ApiController extends Controller
{
    public function getSurvey(Request $request)
    {
        try {
            $survey_id = $request->id;
            $survey = Survey::with([
                'property',
                'sections.questions.options'
            ])->findOrFail($survey_id);
            return response()->json($survey);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'Cannot find this model']);
        }
    }


    public function submitSurvey(Request $request)
    {
        try {
            $count = 0;
            $survey_id = $request->survey_id;
            $datas = $request->data;

            if ($request->participant) {
                if (isset($request->participant['name']) && isset($request->participant['email'])) {
                    $participant = Participant::create([
                        'name' => $request->participant['name'],
                        'email' => $request->participant['email']
                    ]);
                }
            }else{
                $participant = null;
            }

            $response = Response::create([
                'survey_id' => $survey_id,
                'participant_id' => $participant ? $participant->id : null
            ]);

            if ($response) {
                foreach ($datas as $data) {
                    Answer::create([
                        'response_id' => $response['id'],
                        'question_id' => $data['question_id'],
                        'option_id' => isset($data['option_id']) ? $data['option_id'] : null,
                        'option_text' => $data['option_text'],
                    ]);
                    $count++;
                }
                if ($count == count($datas)) {
                    return response()->json([
                        'msg' => 'Thank you for your time, your survey has been submitted successfully.',
                        'success' => true
                    ]);
                } else {
                    return response()->json([
                        'msg' => 'There was an issue with your submission. Please try again.',
                        'success' => false
                    ], 500);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'msg' => 'An error occurred. Please try again later.',
                'error' => $e->getMessage(),
                'success' => false
            ], 500);
        }
    }
}
