<?php

namespace App\Http\Controllers\Regulator;

use App\Http\Controllers\Controller;
use App\Models\Regulator\Regulator;
use App\Services\FileUpload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RegulatorController extends Controller
{
    public function listing(Request $req)
    {
        $data = Regulator::select('*');
        //Filter
        // if ($req->key && $req->key != '') {
        //     $data = $data->where('code', 'LIKE', '%' . $req->key . '%')->Orwhere('name', 'LIKE', '%' . $req->key . '%');
        // }
        // if ($req->type && $req->type != 0) {
        //     $data = $data->where('type_id', $req->type);
        // }
        $data = $data->orderBy('id', 'desc')->get();
        return response()->json($data, Response::HTTP_OK);
    }

    public function view($id = 0)
    {
        $data = Regulator::select('*')->find($id);
        if ($data) {
            return response()->json($data, 200);
        } else {
            return response()->json([
                'status'  => 'fail',
                'message' => 'រកទិន្នន័យមិនឃើញក្នុងប្រព័ន្ធ'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function create(Request $req)
    {
        //==============================>> Check validation
        $this->validate(
            $req,
            [
                'name'              => 'required|max:50',
            ],
            [
                'name.required'         => 'សូមបញ្ចូលឈ្មោះនិយតករ',
                'name.max'              => 'ឈ្មោះនិយតករមិនអាចលើសពី៥០ខ្ទង់',
            ]
        );

        //==============================>> Start Adding data

        $regulator                =   new Regulator;
        $regulator->name          =   $req->name;
        $regulator->is_active     =   $req->is_active;
        $regulator->save();

        //==============================>> Start Uploading Image  
        $folder = Carbon::today()->format('d') . '-' . Carbon::today()->format('M') . '-' . Carbon::today()->format('Y');    
        if ($req->image) {
            // Need to create folder before storing images       
            $folder = Carbon::today()->format('d') . '-' . Carbon::today()->format('M') . '-' . Carbon::today()->format('Y');
            $image  = FileUpload::uploadFile($req->image, 'regulators/' . $folder, $req->fileName);
            if ($image['url']) {
                $regulator->image = $image['url'];
                $regulator->save();
            }
        }

        return response()->json([
            'data'      =>  Regulator::select('*')->find($regulator->id),
            'message'   => 'និយតករត្រូវបានបង្កើតដោយជោគជ័យ។'
        ], Response::HTTP_OK);
    }
    public function update(Request $req, $id = 0)
    {
        //==============================>> Check validation
        $this->validate(
            $req,
            [
                'name'              => 'required|max:50',
            ],
            [
                'name.required'         => 'សូមបញ្ចូលឈ្មោះនិយតករ',
                'name.max'              => 'ឈ្មោះនិយតករមិនអាចលើសពី៥០ខ្ទង់',
            ]
        );

        //==============================>> Start Updating data
        $regulator                         = Regulator::find($id);
        if ($regulator) {

            $regulator->name          = $req->name;
            $regulator->is_active     =   $req->is_active;
            $regulator->save();

            // Need to create folder before storing images
            $folder = Carbon::today()->format('d') . '-' . Carbon::today()->format('M') . '-' . Carbon::today()->format('Y');
            if ($req->image) {
                $image  = FileUpload::uploadFile($req->image, 'regulators/' . $folder, $req->fileName);
                if ($image['url']) {
                    $regulator->image = $image['url'];
                    $regulator->save();
                }
            }

            $regulator = Regulator::select('*')
            ->find($regulator->id);

            return response()->json([
                'status'    => 'ជោគជ័យ',
                'message'   => 'និយតករត្រូវបានកែប្រែជោគជ័យ',
                'regulator'   => $regulator,
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
        $data = Regulator::find($id);

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

    public function updateStatus($id = 0)
    {
        //==============================>> Start Updating Status
        $data = Regulator::find($id);
        if ($data) {
            $data->is_active  =  !$data->is_active;
            $data->save();
            return response(['message' => 'ស្ថានភាពត្រូវបានកែប្រែ'], Response::HTTP_OK);
        } else {
            return response(['message' => 'មិនមានទិន្នន័យក្នុងប្រព័ន្ធ'], Response::HTTP_BAD_REQUEST);
        }
    }
}
/*
|--------------------------------------------------------------------------
| Develop by: Yun Sothearith
|--------------------------------------------------------------------------
|
| date: 23/02/2023. location: CamCyber
|
*/
