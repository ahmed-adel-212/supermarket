<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends AbstractApiController
{
    public function userInfo(Request $request, $userId)
    {
        $user=User::find($userId);
        if($user){
            $data=['userData' => [$user]];
            return $this->sendResponse($data, __('general.successfully_retrived'));
        }
        
        $data=['userData' => []];
        return $this->sendError(__('auth.unauthorised!'), $credentials, 401);
    }

    public function EditUserInfo(Request $request, $userId)
    {
        $user=User::find($userId);
        if(!$user){
            $data=['userData' => []];
            return $this->sendError(__('auth.unauthorised!'),$data, 401);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
            "image"=> "nullable|string",
            "phone"=> "required|string",
            "name"=> "required|string",
        ]);
        if ($validator->fails()) {
            return ['error' => $validator->errors()];
        }

        if($request->hasFile('image'))
        {
            $oldImage = substr($user->image, strlen(url('/')));
            $image = $request->image;
            $image_new_name = time() . $image->getClientOriginalName();
            Storage::disk('local')->put($image_new_name, 'userImage');
            $img = '/userImage/' . $image_new_name;
        }
        $user->update([
            'email'=>$request->email,
            'password'=>$request->password,
            'image'=>$img,
            'phone'=>$request->phone,
            'name'=>$request->name
        ]);

        if($user){
            $data=['userData' => [$user]];
            return $this->sendResponse($data, __('general.user_updated_successfully'));
        }
      
    }

}
