<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\CapDau;
use App\Model\KetQua;
use App\Model\MuaGiai;
use Carbon\Carbon;
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
            $check = CapDau::where('vongdau', ($round - 1))->get();

            if (!($check->count())) {
                $request->session()->flash('msg', 'This action can not be performed !');

                return redirect()->route('admin.update.index');
            }
        }

        $matchs = MuaGiai::where('vongdau', $round)->with('sanvandong', 'doinha', 'doikhach')->get();

        return view('admin.update.update', compact('matchs'));
    }

    public function update(Request $request, $id)
    {
        $match = MuaGiai::findOrFail($id);
        $check = [
            'doinha_id' => $match->doinha_id,
            'doikhach_id' => $match->doikhach_id,
            'vongdau' => $match->vongdau,
        ];

        $home = [
            'doibong_id' => $match->doinha_id,
            'vongdau' => $match->vongdau,
        ];

        $away = [
            'doibong_id' => $match->doikhach_id,
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

        if ($request->home_goals > $request->away_goals) {
            $kq1 = [
                'doibong_id' => $match->doinha_id,
                'vongdau' => $match->vongdau,
                'date' => Carbon::parse($match->date)->format('Y-m-d'),
                'time' => Carbon::parse($match->time)->format('H:i'),
                'status' => 1,
            ];

            $kq2 = [
                'doibong_id' => $match->doikhach_id,
                'vongdau' => $match->vongdau,
                'date' => Carbon::parse($match->date)->format('Y-m-d'),
                'time' => Carbon::parse($match->time)->format('H:i'),
                'status' => -1,
            ];

            KetQua::updateOrCreate($home, $kq1);
            KetQua::updateOrCreate($away, $kq2);
        } else {
            if ($request->home_goals < $request->away_goals) {
                $kq1 = [
                    'doibong_id' => $match->doinha_id,
                    'vongdau' => $match->vongdau,
                    'date' => Carbon::parse($match->date)->format('Y-m-d'),
                    'time' => Carbon::parse($match->time)->format('H:i'),
                    'status' => -1,
                ];

                $kq2 = [
                    'doibong_id' => $match->doikhach_id,
                    'vongdau' => $match->vongdau,
                    'date' => Carbon::parse($match->date)->format('Y-m-d'),
                    'time' => Carbon::parse($match->time)->format('H:i'),
                    'status' => 1,
                ];

                KetQua::updateOrCreate($home, $kq1);
                KetQua::updateOrCreate($away, $kq2);
            } else {
                $kq1 = [
                    'doibong_id' => $match->doinha_id,
                    'vongdau' => $match->vongdau,
                    'date' => Carbon::parse($match->date)->format('Y-m-d'),
                    'time' => Carbon::parse($match->time)->format('H:i'),
                    'status' => 0,
                ];

                $kq2 = [
                    'doibong_id' => $match->doikhach_id,
                    'vongdau' => $match->vongdau,
                    'date' => Carbon::parse($match->date)->format('Y-m-d'),
                    'time' => Carbon::parse($match->time)->format('H:i'),
                    'status' => 0,
                ];

                KetQua::updateOrCreate($home, $kq1);
                KetQua::updateOrCreate($away, $kq2);
            }
        }

        return redirect()->route('admin.update.index');
    }
}
