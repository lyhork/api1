<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Regulator\Regulator;
use App\Models\Survey\Type;
use App\Models\Survey\Survey;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\CamCyber\Bot\BotNotification; 

class PublicController extends Controller
{
    public function regulator()
    {
        $data = Regulator::select('id', 'name', 'image', 'is_active')
        ->where('is_active',1)
        ->get();
        return response()->json($data, Response::HTTP_OK);
    }
    public function viewRegulator($id = 0)
    {
        $data = Regulator::select('id', 'name', 'image', 'is_active')->find($id);
        if ($data) {
            return response()->json($data, Response::HTTP_OK);
        }
        return response()->json(['meassage' => 'លេខសម្គាល់មិនត្រឹមត្រូវ'], Response::HTTP_BAD_REQUEST);
    }
    public function surveyType(){
        $data = Type::select('id', 'name', 'image')->get();
        return response()->json($data, Response::HTTP_OK);
    }

 
    /** Get Survey */ 
    public function survey(){
        $data = Survey::select('id', 'regulator_id', 'type_id', 'comment', 'description')
        ->with(['type','regulator'])
        ->orderBy('id', 'desc')
        ->first();
        return response()->json($data, Response::HTTP_OK);
    }

    /** View Survey */
    public function viewSurvey($id = 0)
    {
        $data = Survey::select('id', 'regulator_id', 'type_id', 'comment', 'description')->with(['type','regulator'])->find($id);
        if ($data) {
            return response()->json($data, Response::HTTP_OK);
        }
        return response()->json(['meassage' => 'លេខសម្គាល់មិនត្រឹមត្រូវ'], Response::HTTP_BAD_REQUEST);
    }

    /** Submit Survey Comment */
    public function submitSurvey(Request $req, $regulator_id = 0 , $type_id = 0)
    {

        //==============================>> Start Submit Survey data
        $survey                         =   new Survey;
        $survey->regulator_id           =   $regulator_id;
        $survey->type_id                =   $type_id;
        $survey->created_at             =   Carbon::now();
        $survey->updated_at             =   Carbon::now();
        $survey->save();

        //ToDo: Send Notification
        $botRes = BotNotification::survey($survey); 

        return response()->json([
            'data'      =>  Survey::select('id', 'regulator_id', 'type_id', 'comment', 'description', 'date_at')->with(['type','regulator'])->find($survey->id),
            'botRes'        => $botRes,
            'message'   => 'ការស្ទង់មតិត្រូវបានបង្កើតដោយជោគជ័យ។'
        ], Response::HTTP_OK);
    }

    

    /** Save Survey */
    public function saveSurvey(Request $req, $id = 0)
    {

        //==============================>> Start Updating data
        $survey                             = Survey::find($id);
        if (!$survey->comment) {
            
            $survey->comment                =   $req->comment;
            $survey->updated_at             =   Carbon::now();
            $survey->save();

            $survey = Survey::select('*')
            ->with([
                'type',
                'regulator'
            ])
            ->find($survey->id);

            //ToDo: Send Notification
            $botRes = BotNotification::survey($survey); 

            return response()->json([
                'status'    => 'ជោគជ័យ',
                'message'   => 'ការស្ទង់មតិត្រូវបានបង្កើតដោយជោគជ័យ។',
                'survey'   => $survey,
                'botRes'        => $botRes
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status'    => 'បរាជ័យ',
                'message'   => 'ទិន្នន័យមិនត្រឹមត្រូវ',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}
