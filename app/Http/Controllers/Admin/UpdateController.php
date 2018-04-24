<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\CapDau;
use App\Model\KetQua;
use App\Model\MuaGiai;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function index()
    {
        return view('admin.update.index');
    }

    public function search(Request $request)
    {
        $round = $request->round;

        if (1 != $round) {
            if (2 == $round) {
                $check = CapDau::where('vongdau', 1)->count();

                if (10 != $check) {
                    $request->session()->flash('msg', 'This action can not be performed !');

                    return redirect()->route('admin.update.index');
                }
            } else {
                $check = CapDau::where('vongdau', ($round - 1))->get();

                if (!($check->count())) {
                    $request->session()->flash('msg', 'This action can not be performed !');

                    return redirect()->route('admin.update.index');
                }
            }
        }

        return redirect()->route('admin.update.show', compact('round'));
    }

    public function show($round)
    {
        $bxh = DB::table('ketqua')
            ->join('doibong', 'doibong.id', '=', 'ketqua.doibong_id')
            ->selectRaw('doibong_id,
            count(CASE WHEN status = 1 THEN 1 ELSE NULL END) as thang,
            count(CASE WHEN status = 0 THEN 1 ELSE NULL END) as hoa,
            count(CASE WHEN status = -1 THEN 1 ELSE NULL END) as thua,
            sum(banthang) as banthang,
            sum(banthua) as banthua')
            ->orderBy('thang', 'DESC')
            ->orderBy('hoa', 'DESC')
            ->orderBy('thua', 'DESC')
            ->orderBy('doibong.name', 'ASC')
            ->groupBy('doibong_id')->get();

        $matchs = MuaGiai::where('vongdau', $round)->with('sanvandong', 'doinha', 'doikhach')->get();

        return view('admin.update.update', compact('matchs', 'bxh'));
    }

    public function update(Request $request, $id)
    {
        $match = MuaGiai::findOrFail($id);
        $check = [
            'doinha_id' => $match->doinha_id,
            'doikhach_id' => $match->doikhach_id,
            'vongdau' => $match->vongdau,
        ];

        $capDau = [
            'date' => Carbon::parse($match->date)->format('Y-m-d'),
            'time' => Carbon::parse($match->time)->format('H:i'),
            'doinha_id' => $match->doinha_id,
            'doikhach_id' => $match->doikhach_id,
            'vongdau' => $match->vongdau,
            'doinha_goals' => $request->home_goals,
            'doikhach_goals' => $request->away_goals,
        ];

        CapDau::updateOrCreate($check, $capDau);

        $home = [
            'doibong_id' => $match->doinha_id,
            'muagiai_id' => $id,
        ];

        $away = [
            'doibong_id' => $match->doikhach_id,
            'muagiai_id' => $id,
        ];
        if ($request->home_goals > $request->away_goals) {
            $kq1 = [
                'doibong_id' => $match->doinha_id,
                'muagiai_id' => $id,
                'status' => 1,
                'date' => Carbon::parse($match->date)->format('Y-m-d'),
                'time' => Carbon::parse($match->time)->format('H:i'),
                'banthang' => $request->home_goals,
                'banthua' => $request->away_goals,
            ];

            $kq2 = [
                'doibong_id' => $match->doikhach_id,
                'muagiai_id' => $id,
                'status' => -1,
                'date' => Carbon::parse($match->date)->format('Y-m-d'),
                'time' => Carbon::parse($match->time)->format('H:i'),
                'banthang' => $request->away_goals,
                'banthua' => $request->home_goals,
            ];

            KetQua::updateOrCreate($home, $kq1);
            KetQua::updateOrCreate($away, $kq2);
        } else {
            if ($request->home_goals < $request->away_goals) {
                $kq1 = [
                    'doibong_id' => $match->doinha_id,
                    'muagiai_id' => $id,
                    'status' => -1,
                    'date' => Carbon::parse($match->date)->format('Y-m-d'),
                    'time' => Carbon::parse($match->time)->format('H:i'),
                    'banthang' => $request->home_goals,
                    'banthua' => $request->away_goals,
                ];

                $kq2 = [
                    'doibong_id' => $match->doikhach_id,
                    'muagiai_id' => $id,
                    'status' => 1,
                    'date' => Carbon::parse($match->date)->format('Y-m-d'),
                    'time' => Carbon::parse($match->time)->format('H:i'),
                    'banthang' => $request->away_goals,
                    'banthua' => $request->home_goals,
                ];

                KetQua::updateOrCreate($home, $kq1);
                KetQua::updateOrCreate($away, $kq2);
            } else {
                $kq1 = [
                    'doibong_id' => $match->doinha_id,
                    'muagiai_id' => $id,
                    'status' => 0,
                    'date' => Carbon::parse($match->date)->format('Y-m-d'),
                    'time' => Carbon::parse($match->time)->format('H:i'),
                    'banthang' => $request->home_goals,
                    'banthua' => $request->away_goals,
                ];

                $kq2 = [
                    'doibong_id' => $match->doikhach_id,
                    'muagiai_id' => $id,
                    'status' => 0,
                    'date' => Carbon::parse($match->date)->format('Y-m-d'),
                    'time' => Carbon::parse($match->time)->format('H:i'),
                    'banthang' => $request->away_goals,
                    'banthua' => $request->home_goals,
                ];

                KetQua::updateOrCreate($home, $kq1);
                KetQua::updateOrCreate($away, $kq2);
            }
        }
        $round = $match->vongdau;

        return redirect()->route('admin.update.show', compact('round'));
    }
}
