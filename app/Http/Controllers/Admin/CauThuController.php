<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\CauThu;
use App\Model\DoiBong;
use Illuminate\Http\Request;

class CauThuController extends Controller
{
    public function index()
    {
        $cauThu = CauThu::orderBy('id', 'DESC')->paginate(10);

        return view('admin.cauthu.index', compact('cauThu'));
    }

    public function trangThai($nid)
    {
        $objItem = CauThu::FindOrFail($nid);
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

        CauThu::destroy($id);

        $request->session()->flash('msg', 'Delete Success');
        return redirect()->route('admin.player.index');
    }

    public function getEdit(CauThu $cauThu)
    {
        $doiBong = DoiBong::all();
        return view("admin.cauthu.edit", compact("cauThu", "doiBong"));
    }

    public function postEdit($id, Request $request)
    {
        $objUser = CauThu::FindOrFail($id);
        $email = $request->email;
        $check = CauThu::where('email', '=', $email)->where('id', '!=', $id)->first();

        if (null != $check) {
            $request->session()->flash('email', 'This email has already existed !');
            return redirect()->route('admin.player.getedit', $id);
        } else {

            $objUser->chitiet = $request->chitiet;
            $objUser->vitri = $request->position;
            $objUser->ngaysinh = $request->brithday;
            $objUser->email = $request->email;
            $objUser->name = $request->username;
            $objUser->fullname = $request->fullname;
            $objUser->diachi = $request->address;
            $objUser->soao = $request->number;
            $objUser->doibong_id = $request->doibong;

            $picture = $request->hinhanh;

            if (isset($request->delete_picture)) {
                //giao diện có hiện thị ra checkbox nhưng k chọn thì vẫn k tồn tại
                if ("" == $picture) {
                    $request->session()->flash('hinhanh', 'Please choose images');
                    return redirect()->route('admin.player.getedit', $id);
                    die();
                }
                $oldPic = $objUser->hinhanh;

                unlink("files/cauthu/" . $oldPic);

                $path = "files/cauthu/";
                $fileName = str_random('10') . time() . '.' . $picture->getClientOriginalExtension();

                $picture->move($path, $fileName);

                $objUser->hinhanh = $fileName;

                if ($objUser->update()) {
                    $request->session()->flash('msg', 'Edit success');
                    return redirect()->route('admin.player.index');
                } else {
                    $request->session()->flash('msg', 'Edit failed');
                    return redirect()->route('admin.player.getedit', $id);
                }
            } else {

                if ("" != $picture) {
                    $path = "files/cauthu/";
                    $fileName = str_random('10') . time() . '.' . $picture->getClientOriginalExtension();

                    $picture->move($path, $fileName);

                    $objUser->hinhanh = $fileName;

                    //xóa ảnh cũ
                    $oldPic = $objUser->hinhanh;
                    if ("" != $oldPic) {
                        unlink("files/cauthu/" . $oldPic);
                    }

                    if ($objUser->update()) {
                        $request->session()->flash('msg', 'Edit success');
                        return redirect()->route('admin.player.index');
                    } else {
                        $request->session()->flash('msg', 'Edit failed');
                        return redirect()->route('admin.player.getedit', $id);
                    }
                } else {
                    if ($objUser->update()) {
                        $request->session()->flash('msg', 'Edit success');
                        return redirect()->route('admin.player.index');
                    } else {
                        $request->session()->flash('msg', 'Edit failed');
                        return redirect()->route('admin.player.getedit', $id);
                    }
                }
            }
        }

        if ($objUser->update()) {
            $request->session()->flash('msg', 'Edit success');
            return redirect()->route('admin.player.index');
        } else {
            $request->session()->flash('msg', 'Edit failed');
            return redirect()->route('admin.player.getedit', $id);
        }
    }

    public function getAdd()
    {
        $doiBong = DoiBong::all();

        return view('admin.cauthu.add', compact('doiBong'));
    }

    public function postAdd(Request $request)
    {
        $email = $request->email;
        $check = CauThu::where('email', '=', $email)->first();

        if (null != $check) {
            $request->session()->flash('email', 'This email has already existed !');
            return redirect()->route('admin.player.getadd');
        } else {
            $picture = $request->hinhanh;

            if ("" == $picture) {
                $request->session()->flash('msg', 'Please choose images');
                return redirect()->route('admin.player.getadd');
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
                'soao' => $request->number,
                'doibong_id' => $request->doibong,
            ];

            $path = "files/cauthu/";
            $fileName = str_random('10') . time() . '.' . $picture->getClientOriginalExtension();
            $picture->move($path, $fileName);

            $arrItem["hinhanh"] = $fileName;

            if (CauThu::insert($arrItem)) {
                $request->session()->flash('msg', 'Add success');
                return redirect()->route('admin.player.index');
            } else {
                $request->session()->flash('msg', 'Add failed');
                return redirect()->route('admin.player.index');
            }
        }
    }
}
