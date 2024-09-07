<?php

namespace App\Http\Controllers\Mobile\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;


class ForgetPasswordController extends Controller
{
    public function sendVerifyMail($email) {
        if(auth()->user()){

            $user = User::where('email',$email)->get();
            if(count($user)>0){
                return $user[0]['id'];

                $random = Str::random(40);
                $domain = URL::to('/');
                $url = $domain.'/'.$random;


                $data['url']= $url;
                $data['email']= $email;
                $data['title']="Email Verification ";
                $data['body']="Please click on below link to reset your password";

                Mail::send('admin/auth/forgetPasswordMail',['data'=>$data],function($message) use($data){
                    $message->to($data['email'])->subject($data['title']);
                });

                User::find($user[0]['id']);
                $user->remember_token = $random;
                $user->save();

                return response()->json(['success'=>true,'msg'=>"Mail sent successfully"]);
            }
            else {
                return response()->json(['success' => false, 'msg' => "User not found"]);
            }
        }
        else{
            return response()->json(['success'=>false,'msg'=>"User is not authenticated"]);
        }
    }


    public function forgetPassword(Request $request)
    {
        try {

            $user = User::where('email', $request->email)->get();

            if(count($user)>0){
                $token = Str::random(40);
                $domain = URL::to('/');
                $url = $domain.'/reset-password?token='.$token;

                $data['url']= $url;
                $data['email']= $request->email;
                $data['title']="Password Reset";
                $data['body']="Please click on below link toi reset your password";

                Mail::send('admin/auth/forgetPasswordMail',['data'=>$data],function($message) use($data){
                    $message->to($data['email'])->subject($data['title']);
                });

             $datetime = Carbon::now()->format('y-m-d H:i:s');
             PasswordReset::updateOrCreate(
                ['email' => $request->email],
                [
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => $datetime,
                ]
                );
                return response()->json(['success'=>true,'msg'=>'Please check your mail to reset your password']);
            }
            else{
                return response()->json(['success'=>false,'msg'=>"User not found"]);
            }

        }
        catch(\Exception $e)
        {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }
}
