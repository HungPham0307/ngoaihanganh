<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\confirmedPassRequest;
use App\Http\Requests\getPassRequest;
use App\Mail\SendMail;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;

class AuthController extends Controller
{
    public function getLogin()
    {

        return view('admin.user.login');
    }

    public function postLogin(Request $request)
    {
        $userName = trim($request->username);
        $passWord = trim($request->password);

        if (Auth::attempt([
            "username" => $userName,
            "password" => $passWord,
            "active" => 1,
        ])) {
            $request->session()->put('name', $userName);

            return redirect()->route("admin.calendar.index");
        } else {
            if (Auth::attempt([
                "username" => $userName,
                "password" => $passWord,
                "active" => 0,
            ])) {
                $request->session()->flash('msg', 'This account is locked');
                return redirect()->route("admin.user.getlogin");
            } else {
                $request->session()->flash('msg', 'This account is not valid');
                return redirect()->route("admin.user.getlogin");
            }
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('name');
        Auth::logout();
        //return view('admin.user.login');
        return redirect()->route("admin.user.getlogin");
    }

    public function postPass(getPassRequest $request)
    {

        $email = $request->mail;
        $objUser = User::where('email', '=', $email)->first();

        if (null == $objUser) {
            $request->session()->flash('msg', 'Email not valid ! Please check again');
            return redirect()->route("admin.user.getlogin");
        } else {
            $id = $objUser->id;
            $data = mt_rand(1000, 9999);
            $request->session()->put('data', $data); //tạo session để lưu mã xác nhận
            $noidung = "Your confirmation code is : {$data}";
            $request->session()->flash('noidung', $noidung);
            $formdata = $request->except('_token');
            Mail::send(new SendMail($formdata));

            return redirect()->route('admin.user.getConfirm', $id);

            // return view('admin.user.xacnhan',compact('objUser'));
        }
    }

    public function getConfirm($id)
    {
        $objUser = User::FindOrFail($id);
        return view('admin.user.xacnhan', compact('objUser'));
    }

    public function getNewPass($id)
    {
        $objUser = User::FindOrFail($id);
        return view('admin.user.pass', compact('objUser'));
    }

    public function postConfirm(Request $request, $id)
    {
        $maSo = $request->xacnhan;
        if ($request->session()->has('data') && $request->session()->get('data') == $maSo) {
            return redirect()->route('admin.user.getnewpass', $id);

            // return view('admin.user.pass',['id'=>$id]);
        } else {
            $request->session()->flash('msg', 'Code is incorrect');
            //  $objUser = User::FindOrFail($id);
            //   return view('admin.user.xacnhan',compact('objUser'));
            return redirect()->route('admin.user.getConfirm', $id);
        }
    }

    public function done(confirmedPassRequest $request, $id)
    {

        $objUser = User::FindOrFail($id);
        $passWord = bcrypt(trim($request->password));
        $objUser->password = $passWord;
        if ($objUser->update()) {
            $request->session()->flash('msg', 'Login now !');
            return redirect()->route('admin.user.getlogin');
        } else {
            $request->session()->flash('msg', 'Please check again');
            return redirect()->route('admin.user.getlogin');
        }
    }
}
