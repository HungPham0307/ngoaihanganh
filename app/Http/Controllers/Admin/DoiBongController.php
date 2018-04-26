<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\DoiBong;
use App\Model\SanVanDong;
use DB;
use Illuminate\Http\Request;

class DoiBongController extends Controller
{
    public function index()
    {
        $doiBong = DoiBong::orderBy('id', 'DESC')->paginate(10);

        return view('admin.doibong.index', compact('doiBong'));
    }

    public function trangThai($nid)
    {
        $objItem = DoiBong::FindOrFail($nid);
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
        $stadium_id = DoiBong::whereIn('id', $id)->pluck('sanvandong_id')->toArray();

        DoiBong::destroy($id);

        DB::table('cauthu')->whereIn('doibong_id', $id)->delete();

        DB::table('sanvandong')->whereIn('id', $stadium_id)->delete();

        $request->session()->flash('msg', 'Delete Success');

        return redirect()->route('admin.football.index');
    }

    public function getEdit($id)
    {

        $doiBong = DoiBong::with('sanVanDong')->findOrFail($id);

        return view("admin.doibong.edit", compact("doiBong"));
    }

    public function export(Request $request)
    {
        $countries = DB::table('doibong')->select('id', 'name')->get();
        $tot_record_found = 0;
        if (count($countries) > 0) {
            $tot_record_found = 1;
            //First Methos
            $export_data = "ID,Name\n";
            foreach ($countries as $value) {
                $export_data .= $value->id . ',' . $value->name . "\n";
            }
            return response($export_data)
                ->header('Content-Type', 'application/csv')
                ->header('Content-Disposition', 'attachment; filename="download.csv"')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        }
        die();
    }

    public function postEdit($id, Request $request)
    {
        $club = DoiBong::FindOrFail($id);
        $email = $request->email;
        $name = $request->name_club;
        $checkEmail = DoiBong::where('email', $email)->where('id', '!=', $id)->first();

        $checkName = DoiBong::where('name', $name)->where('id', '!=', $id)->first();

        if (null != $checkEmail) {
            $request->session()->flash('email', 'This email has already existed !');

            return redirect()->route('admin.football.getedit', $id);
        } else {

            if (null != $checkName) {
                $request->session()->flash('name_club', 'This name club has already existed !');

                return redirect()->route('admin.football.getedit', $id);
            }

            $club->chitiet = $request->chitiet;
            $club->website = $request->link;
            $club->email = $email;
            $club->name = $name;
            $club->diachi = $request->address;
            $club->ngaythanhlap = $request->birthday;

            $picture_club = $request->hinhanh;
            $picture_stadium = $request->picutre_stadium;

            $stadium = SanVanDong::findOrFail($club->sanvandong_id);

            $stadium->name = $request->name_stadium;
            $stadium->suc_chua = $request->total_number;
            $stadium->chitiet = $request->detail_stadium;

            if (isset($request->delete_picture_club) || isset($request->delete_picture_stadium)) {
                //giao diện có hiện thị ra checkbox nhưng k chọn thì vẫn k tồn tại
                if ("" == $picture_club) {
                    $request->session()->flash('hinhanh', 'Please choose images');

                    return redirect()->route('admin.football.getedit', $id);
                    die();
                }

                //giao diện có hiện thị ra checkbox nhưng k chọn thì vẫn k tồn tại
                if ("" == $picture_stadium) {
                    $request->session()->flash('picutre_stadium', 'Please choose images');

                    return redirect()->route('admin.football.getedit', $id);
                    die();
                }

                $oldPicClub = $club->hinhanh;

                unlink("files/doibong/" . $oldPicClub);

                $path = "files/doibong/";

                $nameClub = str_random('10') . time() . '.' . $picture_club->getClientOriginalExtension();

                $picture_club->move($path, $nameClub);

                $club->hinhanh = $nameClub;

                $oldPicStadium = $stadium->hinhanh;

                unlink("files/sanvandong/" . $oldPicStadium);

                $path = "files/sanvandong/";

                $nameStadium = str_random('10') . time() . '.' . $picture_stadium->getClientOriginalExtension();

                $picture_stadium->move($path, $nameStadium);

                $stadium->hinhanh = $nameStadium;
            }

            DB::beginTransaction();
            try {
                $club->update();
                $stadium->update();
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();

                return $this->respondServerError();
            }

            $request->session()->flash('msg', 'Edit success');

            return redirect()->route('admin.football.index');
        }
    }

    public function getAdd(Request $request)
    {
        $doiBong = DoiBong::all();

        if ($doiBong->count() == 20) {
            $request->session()->flash('msg', 'Add club failed ! Total number of club is 20');

            return redirect()->route('admin.football.index');
        }

        return view('admin.doibong.add', compact('doiBong'));
    }

    public function postAdd(Request $request)
    {
        $email = $request->email;
        $check = DoiBong::where('email', '=', $email)->first();

        if (null != $check) {
            $request->session()->flash('email', 'This email has already existed !');
            return redirect()->route('admin.football.getadd');
        } else {
            $picture_stadium = $request->picutre_stadium;
            $picture_club = $request->hinhanh;

            if ("" == $picture_club || "" == $picture_stadium) {
                $request->session()->flash('msg', 'Please choose images');

                return redirect()->route('admin.football.getadd');
                die();
            }

            $arrStadium = [
                "name" => $request->name_stadium,
                "suc_chua" => $request->total_number,
                "chitiet" => $request->detail_stadium,
            ];

            $path = "files/sanvandong/";
            $fileName = str_random('10') . time() . '.' . $picture_stadium->getClientOriginalExtension();
            $picture_stadium->move($path, $fileName);

            $arrStadium["hinhanh"] = $fileName;

            $arrClub = [
                "name" => $request->name_club,
                "website" => $request->link,
                "diachi" => $request->address,
                "email" => $request->email,
                "ngaythanhlap" => $request->date,
                "chitiet" => $request->chitiet,
            ];

            $path = "files/doibong/";
            $fileName = str_random('10') . time() . '.' . $picture_club->getClientOriginalExtension();
            $picture_club->move($path, $fileName);

            $arrClub["hinhanh"] = $fileName;

            DB::beginTransaction();
            try {
                $stadium_id = DB::table('sanvandong')->insertGetId($arrStadium);

                $arrClub['sanvandong_id'] = $stadium_id;
                DB::table('doibong')->insert($arrClub);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();

                return $this->respondServerError();
            }

            $request->session()->flash('msg', 'Add success');

            return redirect()->route('admin.football.index');
        }
    }
}
