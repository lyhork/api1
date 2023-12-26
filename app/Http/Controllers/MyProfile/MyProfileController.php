<?php

namespace App\Http\Controllers\MyProfile;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use App\Services\FileUpload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class MyProfileController extends Controller
{
    public function get()
    {
        $auth = JWTAuth::parseToken()->authenticate();
        $admin = User::select('id', 'name', 'phone', 'email', 'avatar')->where('id', $auth->id)->first();
        return response()->json($admin, Response::HTTP_OK);
    }

    public function update(Request $req)
    {
        $user_id = JWTAuth::parseToken()->authenticate()->id;
        $this->validate($req, [
            'name'  => 'required|max:60',
            'phone' => 'required|regex:/(^[0][0-9].{7}$)|(^[0][0-9].{8}$)/'
            ,
        ],[
            'name.required' => 'សូមបញ្ចូលឈ្មោះ',
            'name.max'      => 'ឈ្មោះមិនអាចលើសពី៦០',
            'phone.required'=> 'សូមបញ្ចូលលេខទូរស័ព្ទ',
            'phone.regex'   => 'សូមបញ្ចូលលេខទូរស័ព្ទឲ្យបានត្រឹមត្រូវ'
        ]);

        //========================================================>>>> Start to update user
        $user = User::findOrFail($user_id);
        $user->name = $req->name;
        $user->phone = $req->phone;
        $user->email = $req->email;
        $user->updated_at = Carbon::now()->format('Y-m-d H:i:s');

        //Start to upload image 
        $res    = FileUpload::uploadFile($req->image, 'my-profile', $req->fileName);
        if ($res) {
            if (isset($res['url'])) {
                if ($res['url'] != '') {
                    $user->avatar          = $res['url'];
                }
            }
        }
        $user->save();

        return response()->json([
            'status'    => 'ជោគជ័យ',
            'message'   => 'ការកែប្រែបានជោគជ័យ',
            'data'      => $user
        ], Response::HTTP_OK);
    }
    public function changePassword(Request $req)
    {
        $old_password = $req->old_password;
        $user_id = JWTAuth::parseToken()->authenticate()->id;
        $current_password = User::find($user_id)->password;

        if (Hash::check($old_password, $current_password)) {

            //==============================>> Check validation
            $this->validate($req, [
                'password'          => 'required|min:6|max:20',
                'confirm_password'  => 'required|same:password'
            ], [
                'password.required'         => 'សូមបញ្ចូលលេខសម្ងាត់',
                'password.min'              => 'សូមបញ្ចូលលេខសម្ងាត់ធំជាងឬស្មើ៦',
                'password.max'              => 'សូមបញ្ចូលលេខសម្ងាត់តូចឬស្មើ២០',
                'confirm_password.required' => 'សូមបញ្ចូលបញ្ជាក់ពាក្យសម្ងាត់',
                'confirm_password.same'     => 'សូមបញ្ចូលបញ្ជាក់ពាក្យសម្ងាត់ឲ្យដូចលេខសម្ងាត់',
            ]);

            //========================================================>>>> Start to update user
            $user = User::findOrFail($user_id);
            $user->password = Hash::make($req->password);
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'ការកែបានជោគជ័យ!'
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'ពាក្យសម្ងាត់ចាស់របស់អ្នកមិនត្រឹមត្រូវ'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
