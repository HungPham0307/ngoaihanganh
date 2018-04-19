<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $checkUser = Auth::user();
        if ("admin" == $checkUser->username) {
            $objUser = User::all();
        } else {

            $id = $checkUser->id;
            $objUser = User::where("id", "=", $id)->get();
        }

        return view("admin.user.index", compact("objUser"));
    }

    public function trangThai($nid)
    {
        $objItem = User::FindOrFail($nid);
        if ('0' == $objItem->active) {
            $objItem->active = '1';
            $objItem->update();
            echo "<a href='javascript:void(0)' onclick='getTrangThai( {$nid});'>
                     <img src='/resources/assets/templates/admin/images/active.gif'/>
                </a>";
        } else {
            $objItem->active = '0';
            $objItem->update();
            echo "<a href='javascript:void(0)' onclick='getTrangThai( {$nid});'>
                     <img src='/resources/assets/templates/admin/images/deactive.gif'/>
                </a>";
        }
    }

    public function getAdd()
    {

        return view("admin.user.add");
    }

    public function postAdd(UserRequest $request)
    {
        $userName = trim($request->username);
        $fullName = trim($request->fullname);
        $email = trim($request->email);
        $passWord = bcrypt(trim($request->password));

        //kiểm tra trùng name or email
        $objCheck = User::where("username", "=", $userName)->orWhere('email', '=', $email)->first();

        if (null == $objCheck) {
            $arrUser = [
                "username" => $userName,
                "fullname" => $fullName,
                "password" => $passWord,
                "email" => $email,
                "permission" => "mod",
            ];
            if (User::Insert($arrUser)) {
                $request->session()->flash('msg', 'Thêm thành công');
                return redirect()->route('admin.user.index');
            } else {
                $request->session()->flash('msg', 'Thêm thất bại');
                return redirect()->route('admin.user.getadd');
            }
        } else {
            $request->session()->flash('msg', 'Tên đăng nhập hoặc email đã tồn tại');
            return redirect()->route('admin.user.getadd');
        }
    }

    public function del(Request $request)
    {

        $id = $request->xoa;
        foreach ($id as $did) {
            User::destroy($did);
        }

        $request->session()->flash('msg', 'Xóa thành công');
        return redirect()->route('admin.user.index');
    }

    public function getEdit($id)
    {

        $objUser = User::FindOrFail($id);
        return view("admin.user.edit", compact("objUser"));
    }

    public function postEdit(UserRequest $request, $id)
    {

        $objUser = User::FindOrFail($id);
        $objUser->username = trim($request->username);
        $objUser->fullname = trim($request->fullname);
        $objUser->email = trim($request->email);
        $pass = trim($request->password);
        //kiểm tra trùng tên đăng nhập
        $objCheckName = User::where("username", "=", $objUser->username)->where("id", "!=", $id)->first();

        $objCheckEmail = User::where("email", "=", $objUser->email)->where("id", "!=", $id)->first();

        if (null == $objCheckName && null == $objCheckEmail) {
            if ($objUser->password != $pass) {
                $pass = bcrypt(trim($request->password));
                $objUser->password = $pass;
            }
            if ($objUser->update()) {
                $request->session()->flash('msg', 'Update  thành công');
                return redirect()->route('admin.user.index');
            } else {
                $request->session()->flash('msg', 'Sửa thất bại');
                return redirect()->route('admin.user.getedit');
            }
        } else {
            $request->session()->flash('msg', 'Tên đăng nhập hoặc email bị trùng');
            return redirect()->route('admin.user.getedit', $id);
        }
    }
}
