<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\TrongTai;
use Illuminate\Http\Request;

class TrongTaiController extends Controller
{
    public function index()
    {
        $trongTai = TrongTai::orderBy('id', 'DESC')->paginate(10);

        return view('admin.trongtai.index', compact('trongTai'));
    }

    public function trangThai($nid)
    {
        $objItem = TrongTai::FindOrFail($nid);
        if ('0' == $objItem->active) {
            $objItem->active = '1';
            $objItem->update();
            echo "<a href='javascript:void(0)' onclick='getTrangThai( {$nid});'>
                 <img src='/templates/admin/images/active.gif'/>
            </a>";
        } else {
            $objItem->active = '0';
            $objItem->update();
            echo "<a href='javascript:void(0)' onclick='getTrangThai( {$nid});'>
                 <img src='/templates/admin/images/deactive.gif'/>
            </a>";
        }
    }

    public function del(Request $request)
    {

        $id = $request->xoa;

        Trongtai::destroy($id);

        $request->session()->flash('msg', 'Delete Success');
        return redirect()->route('admin.referee.index');
    }

    public function getEdit($id)
    {

        $objUser = TrongTai::FindOrFail($id);

        return view("admin.trongtai.edit", compact("objUser"));
    }

    public function postEdit($id, Request $request)
    {
        $objUser = TrongTai::FindOrFail($id);
        $email = $request->email;
        $check = TrongTai::where('email', '=', $email)->where('id', '!=', $id)->first();

        if (null != $check) {
            $request->session()->flash('email', 'This email has already existed !');
            return redirect()->route('admin.referee.getedit', $id);
        } else {

            $objUser->chitiet = $request->chitiet;
            $objUser->vitri = $request->position;
            $objUser->ngaysinh = $request->brithday;
            $objUser->email = $request->email;
            $objUser->name = $request->username;
            $objUser->fullname = $request->fullname;
            $objUser->diachi = $request->address;

            $picture = $request->hinhanh;

            if (isset($request->delete_picture)) {
                //giao diện có hiện thị ra checkbox nhưng k chọn thì vẫn k tồn tại
                if ("" == $picture) {
                    $request->session()->flash('hinhanh', 'Please choose images');
                    return redirect()->route('admin.referee.getedit', $id);
                    die();
                }
                $oldPic = $objUser->hinhanh;

                unlink("files/trongtai/" . $oldPic);

                $path = "files/trongtai/";
                $fileName = str_random('10') . time() . '.' . $picture->getClientOriginalExtension();

                $picture->move($path, $fileName);

                $objUser->hinhanh = $fileName;

                if ($objUser->update()) {
                    $request->session()->flash('msg', 'Edit success');
                    return redirect()->route('admin.referee.index');
                } else {
                    $request->session()->flash('msg', 'Edit failed');
                    return redirect()->route('admin.referee.getedit', $id);
                }
            } else {

                if ("" != $picture) {
                    $path = "files/trongtai/";
                    $fileName = str_random('10') . time() . '.' . $picture->getClientOriginalExtension();

                    $picture->move($path, $fileName);

                    $objUser->hinhanh = $fileName;

                    //xóa ảnh cũ
                    $oldPic = $objUser->hinhanh;
                    if ("" != $oldPic) {
                        unlink("files/trongtai/" . $oldPic);
                    }

                    if ($objUser->update()) {
                        $request->session()->flash('msg', 'Edit success');
                        return redirect()->route('admin.referee.index');
                    } else {
                        $request->session()->flash('msg', 'Edit failed');
                        return redirect()->route('admin.referee.getedit', $id);
                    }
                } else {
                    if ($objUser->update()) {
                        $request->session()->flash('msg', 'Edit success');
                        return redirect()->route('admin.referee.index');
                    } else {
                        $request->session()->flash('msg', 'Edit failed');
                        return redirect()->route('admin.referee.getedit', $id);
                    }
                }
            }
        }

        if ($objUser->update()) {
            $request->session()->flash('msg', 'Edit success');
            return redirect()->route('admin.referee.index');
        } else {
            $request->session()->flash('msg', 'Edit failed');
            return redirect()->route('admin.referee.getedit', $id);
        }
    }

    public function getAdd()
    {
        return view('admin.trongtai.add');
    }

    public function postAdd(Request $request)
    {
        $email = $request->email;
        $check = TrongTai::where('email', '=', $email)->first();

        if (null != $check) {
            $request->session()->flash('email', 'This email has already existed !');
            return redirect()->route('admin.referee.getadd');
        } else {
            $picture = $request->hinhanh;

            if ("" == $picture) {
                $request->session()->flash('msg', 'Please choose images');
                return redirect()->route('admin.referee.getadd');
                die();
            }

            $arrItem = [
                "name" => $request->username,
                "fullname" => $request->fullname,
                "diachi" => $request->address,
                "email" => $request->email,
                "ngaysinh" => $request->birthday,
                "vitri" => $request->position,
                "chitiet" => $request->chitiet,
            ];

            $path = "files/trongtai/";
            $fileName = str_random('10') . time() . '.' . $picture->getClientOriginalExtension();
            $picture->move($path, $fileName);

            $arrItem["hinhanh"] = $fileName;

            if (TrongTai::insert($arrItem)) {
                $request->session()->flash('msg', 'Add success');
                return redirect()->route('admin.referee.index');
            } else {
                $request->session()->flash('msg', 'Add failed');
                return redirect()->route('admin.referee.index');
            }
        }
    }
}
