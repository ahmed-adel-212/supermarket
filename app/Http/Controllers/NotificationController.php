<?php
 
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\NotificationToken;
  
class NotificationController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    // public function index()
    // {
    //     return view('pushNotification');
    // } 
  
     /**
     * Write code on Method
     *
     * @return response()
     */
    public static function sendNotification($userId,$title,$body)
    {
        $firebaseToken = NotificationToken::where('user_id',$userId)->pluck('token')->all();
        if($firebaseToken){
            $SERVER_API_KEY = env('FCM_SERVER_KEY');
        
            $data = [
                "registration_ids" => $firebaseToken,
                "notification" => [
                    "title" => $title,
                    "body" => $body,  
                ]
            ];
            $dataString = json_encode($data);
        
            $headers = [
                'Authorization: key=' . $SERVER_API_KEY,
                'Content-Type: application/json',
            ];
        
            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                    
            $response = curl_exec($ch);
            return back()->with('success', 'Notification send successfully.');
        }

        return back()->with('error', 'Faild send Notification.');
        
    }
}