<?php

namespace App\Http\Controllers\Survey;

use App\Http\Controllers\Controller;
use App\Models\Survey\Type;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\FileUpload;
use Carbon\Carbon;

class SurveyTypeController extends Controller
{
    public function listing()
    {
        $data = Type::select('id', 'name', 'image')
            // ->withCount(['products as n_of_products'])
            ->orderBy('name', 'ASC')
            ->get();
        return response()->json($data, Response::HTTP_OK);
    }

    public function create(Request $req)
    {
        //==============================>> Check validation
        $this->validate(
            $req,
            [
                'name'             => 'required|max:20',
            ],
            [
                'name.required'    => 'សូមបញ្ចូលឈ្មោះប្រភេទផលិតផល',
                'name.max'         => 'ឈ្មោះប្រភេទផលិតផលមិនអាចលើសពី២០ខ្ទង់',
            ]
        );

        //==============================>> Start Adding data

        $survey_type           =   new Type;
        $survey_type->name     =   $req->name;
        $survey_type->save();
    
          //==============================>> Start Uploading Image    
          $folder = Carbon::today()->format('d') . '-' . Carbon::today()->format('M') . '-' . Carbon::today()->format('Y'); 
          if ($req->image) {
            // Need to create folder before storing images       
            $folder = Carbon::today()->format('d') . '-' . Carbon::today()->format('M') . '-' . Carbon::today()->format('Y');
            $image  = FileUpload::uploadFile($req->image, 'survey-types/' . $folder, $req->fileName);
            if ($image['url']) {
                $survey_type->image = $image['url'];
                $survey_type->save();
            }
        }


        return response()->json([
            'product_type'  => $survey_type,
            'message'       => 'ទិន្នន័យត្រូវបានបង្កើតដោយជោគជ័យ។'
        ], Response::HTTP_OK);
    }

    public function update(Request $req, $id = 0)
    {
        //==============================>> Check validation
        $this->validate(
            $req,
            [
                'name'          =>  'required|max:20',
            ],
            [
                'name.required' => 'សូមបញ្ចូលឈ្មោះប្រភេទ',
                'name.max'      => 'ឈ្មោះប្រភេទមិនអាចលើសពី២០ខ្ទង់',
            ]
        );

        //==============================>> Start Updating data
        $survey_type           = Type::find($id);
        if ($survey_type) {
            $survey_type->name = $req->name;
            $survey_type->save();

            // Need to create folder before storing images
            $folder = Carbon::today()->format('d') . '-' . Carbon::today()->format('M') . '-' . Carbon::today()->format('Y');
            if ($req->image) {
                $image  = FileUpload::uploadFile($req->image, 'survey-types/' . $folder, $req->fileName);
                if ($image['url']) {
                    $survey_type->image = $image['url'];
                    $survey_type->save();
                }
            }

            return response()->json([
                'status'        => 'ជោគជ័យ',
                'message'       => 'ទិន្នន័យត្រូវបានកែប្រែជោគជ័យ!',
                'survey_type'  => $survey_type,
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
        $data = Type::find($id);

        //==============================>> Start deleting data
        if ($data) {
            $data->delete();
            return response()->json([
                'status'    => 'ជោគជ័យ',
                'message'   => 'ទិន្នន័យត្រូវបានលុប'
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status'    => 'បរាជ័យ',
                'message'   => 'ទិន្នន័យមិនត្រឹមត្រូវ',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
