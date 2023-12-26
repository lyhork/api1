<?php

namespace App\Http\Controllers\Survey;

use App\Http\Controllers\Controller;
use App\Models\Survey\Survey;
use App\Models\User\User;
use App\Services\FileUpload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class SurveyController extends Controller
{
    public function listing(Request $req)
    {
        $user         = JWTAuth::parseToken()->authenticate();
        if($user->type_id == 1){
            $data = Survey::select('*')->with(['type','regulator']);
        }else{
            $data = Survey::select('*')->where('regulator_id', $user->id)->with(['type','regulator']);
        }
        
        //Filter
        if ($req->type && $req->type != 0) {
            $data = $data->where('type_id', $req->type);
        }
        if ($req->regulator && $req->regulator != 0) {
            $data = $data->where('regulator_id', $req->regulator);
        }
        // ==============================>> Date Range
        if($req->from && $req->to && $this->isValidDate($req->from) && $this->isValidDate($req->to)){
            $data = $data->whereBetween('created_at', [$req->from." 00:00:00", $req->to." 23:59:59"]);
        }
        $data = $data->orderBy('id', 'desc')
        ->paginate($req->limit ? $req->limit : 10,'per_page');
        return response()->json($data, Response::HTTP_OK);
    }

    public function create(Request $req)
    {
        //==============================>> Check validation
        $this->validate(
            $req,
            [
                'regulator_id'              => 'required',
                'type_id'                   => 'required',
                'comment'                   => 'required|unique',
            ]
            // [
            //     'name.required'         => 'សូមបញ្ចូលឈ្មោះផលិតផល',
            //     'name.max'              => 'ឈ្មោះផលិតផលមិនអាចលើសពី២០ខ្ទង់',
            // ]
        );

        //==============================>> Start Adding data

        $survey                         =   new Survey;
        $survey->regulator_id           =   $req->regulator_id;
        $survey->type_id                =   $req->type_id;
        $survey->comment                =   $req->comment;
        $survey->description            =   $req->description;
        $survey->created_at             =   Carbon::now();
        $survey->save();


        return response()->json([
            'data'      =>  Survey::select('*')->with(['type','regulator'])->find($survey->id),
            'message'   => 'ការស្ទង់មតិត្រូវបានបង្កើតដោយជោគជ័យ។'
        ], Response::HTTP_OK);
    }
    public function update(Request $req, $id = 0)
    {
        //==============================>> Start Updating data
        $survey                         = Survey::find($id);
        if ($survey) {

            $survey->regulator_id           =   $req->regulator_id;
            $survey->type_id                =   $req->type_id;
            $survey->comment                =   $req->comment;
            $survey->description            =   $req->description;
            $survey->updated_at             =   Carbon::now();
            $survey->save();

            $survey = Survey::select('*')
            ->with([
                'type',
                'regulator'
            ])
            ->find($survey->id);

            return response()->json([
                'status'    => 'ជោគជ័យ',
                'message'   => 'ការស្ទង់មតិត្រូវបានកែប្រែជោគជ័យ',
                'survey'   => $survey,
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status'    => 'បរាជ័យ',
                'message'   => 'ទិន្នន័យមិនត្រឹមត្រូវ',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    public function delete($id = 0)
    {
        $data = Survey::find($id);

        //==============================>> Start deleting data
        if ($data) {
            $data->delete();
            return response()->json([
                'status'    => 'ជោគជ័យ',
                'message'   => 'ទិន្នន័យត្រូវបានលុប',
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status'    => 'បរាជ័យ',
                'message'   => 'ទិន្នន័យមិនត្រឹមត្រូវ',
            ], Response::HTTP_BAD_REQUEST);
        }
    }


 

    function printReport(Request $req){
   
        $data           = Survey::whereMonth('created_at', Carbon::now()->month)
        ->with([
            'type',
            'regulator',
        ]);

        // return $data;
                  

       // ==============================>> Date Range
        if($req->from && $req->to && $this->isValidDate($req->from) && $this->isValidDate($req->to)){
            $data = $data->whereBetween('created_at', [$req->from." 00:00:00", $req->to." 23:59:59"]);
        }

        //Filter
        if ($req->type && $req->type != 0) {
            $data = $data->where('type_id', $req->type);
        }
        
        if ($req->regulator && $req->regulator != 0) {
            $data = $data->where('regulator_id', $req->regulator);
        }

        $data = $data->orderBy('id', 'desc')->get();
        
        $total = 0;
        foreach($data as $row){
            $total += $row->total_price;
        } 
        
        $payload = [
            'from'          => $req->from,
            'to'            => $req->to,
            'regulator_id'  => $req->regulator_id,
            'type_id'        => $req->type_id,
            'total'         => $total,
            'data'          => $data,

        ];

        return $payload;
        // return view('printing.sale.sale', $payload);
    }

}
