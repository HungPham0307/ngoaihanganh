<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\CauThu;
use App\Model\DoiBong;
use App\Model\ViTri;
use Illuminate\Http\Request;

class CauThuController extends Controller
{
    public function index($id)
    {
        $cauThu = CauThu::where('doibong_id', $id)->orderBy('id', 'DESC')->paginate(10);

        return view('admin.doibong.cauthu', compact('cauThu', 'id'));
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
        $id = $request->id_club;

        $idDel = $request->xoa;

        CauThu::destroy($idDel);

        $request->session()->flash('msg', 'Delete Success');

        return redirect()->route('admin.player.index', $id);
    }

    public function getEdit($id)
    {
        $cauThu = CauThu::with('vitri')->findOrFail($id);
        $doiBong = DoiBong::all();
        $viTri = ViTri::all();

        return view("admin.doibong.editcauthu", compact("cauThu", "doiBong", "viTri"));
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
            $objUser->vitri_id = $request->position;
            $objUser->ngaysinh = $request->birthday;
            $objUser->email = $request->email;
            $objUser->name = $request->username;
            $objUser->fullname = $request->fullname;
            $objUser->diachi = $request->address;
            $objUser->soao = $request->number;
            $objUser->doibong_id = $request->doibong;

            $picture = $request->hinhanh;
            $checkSoAo = CauThu::where('doibong_id', $request->doibong)->where('soao', $request->number)->where('id', '!=', $id)->get();

            if ($checkSoAo->count()) {
                $request->session()->flash('number', 'Please choose number again');

                return redirect()->route('admin.player.getedit', $id);
                die();
            }
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
            }

            if ($objUser->update()) {
                $request->session()->flash('msg', 'Edit success');

                return redirect()->route('admin.player.index', $request->doibong);
            } else {
                $request->session()->flash('msg', 'Edit failed');

                return redirect()->route('admin.player.getedit', $id);
            }
        }

        if ($objUser->update()) {
            $request->session()->flash('msg', 'Edit success');

            return redirect()->route('admin.player.index', $request->doibong);
        } else {
            $request->session()->flash('msg', 'Edit failed');

            return redirect()->route('admin.player.getedit', $id);
        }
    }

    public function getAdd($id)
    {
        $viTri = ViTri::all();

        return view('admin.doibong.addcauthu', compact('id', 'viTri'));
    }

    public function postAdd(Request $request, $id)
    {
        $email = $request->email;

        $checkSoAo = CauThu::where('doibong_id', $id)->where('soao', $request->number)->get();

        if ($checkSoAo->count()) {
            $request->session()->flash('number', 'Please choose number again');

            return redirect()->route('admin.player.getadd', $id);
            die();
        }

        $check = CauThu::where('email', '=', $email)->first();

        if (null != $check) {
            $request->session()->flash('email', 'This email has already existed !');

            return redirect()->route('admin.player.getadd', $id);
        } else {
            $picture = $request->hinhanh;

            if ("" == $picture) {
                $request->session()->flash('msg', 'Please choose images');

                return redirect()->route('admin.player.getadd', $id);
                die();
            }

            $arrItem = [
                "name" => $request->username,
                "fullname" => $request->fullname,
                "diachi" => $request->address,
                "email" => $request->email,
                "ngaysinh" => $request->birthday,
                "vitri_id" => $request->position,
                "chitiet" => $request->chitiet,
                'soao' => $request->number,
                'doibong_id' => $id,
            ];

            $path = "files/cauthu/";
            $fileName = str_random('10') . time() . '.' . $picture->getClientOriginalExtension();
            $picture->move($path, $fileName);

            $arrItem["hinhanh"] = $fileName;

            if (CauThu::insert($arrItem)) {
                $request->session()->flash('msg', 'Add success');

                return redirect()->route('admin.player.index', $id);
            } else {
                $request->session()->flash('msg', 'Add failed');

                return redirect()->route('admin.player.index', $id);
            }
        }
    }
}
