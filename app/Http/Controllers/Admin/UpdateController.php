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
            (count(CASE WHEN status = 1 THEN 1 ELSE NULL END)*3 + count(CASE WHEN status = 0 THEN 1 ELSE NULL END)*1) as tongso,
            sum(banthang) as banthang,
            sum(banthua) as banthua,
            (sum(banthang)-sum(banthua)) as hieuso')
            ->orderBy('tongso', 'DESC')
            ->orderBy('hieuso', 'DESC')
            ->orderBy('doibong.name', 'ASC')
            ->groupBy('doibong_id')->get();

        $matchs = MuaGiai::where('vongdau', $round)->with('sanvandong', 'doinha', 'doikhach')->orderBy('date', 'ASC')->orderBy('time', 'ASC')->get();

        return view('admin.update.update', compact('matchs', 'bxh', 'round'));
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
            'sanvandong_id' => $match->sanvandong_id,
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

    public function exportResultRound($round)
    {
        $capdau = CapDau::with('sanvandong', 'doinha', 'doikhach')->where('vongdau', $round)->orderBy('date', 'ASC')->orderBy('time', 'ASC')->get();
        $tot_record_found = 0;
        if (count($capdau)) {
            $tot_record_found = 1;
            //First Methos
            $export_data = "Round,Date,Time,Home_Team,Away_Team,Stadium,Result\n";
            foreach ($capdau as $value) {
                $export_data .= $value->vongdau . ',' . Carbon::parse($value->date)->format('Y-m-d') . ',' . Carbon::parse($value->time)->format('H:i') .
                ' PM ,' . $value->doinha->name . ',' . $value->doikhach->name . ',' . $value->sanvandong->name . ',' . $value->doinha_goals . '-' . $value->doikhach_goals . "\n";
            }
            return response($export_data)
                ->header('Content-Type', 'application/csv')
                ->header('Content-Disposition', 'attachment; filename="result.csv"')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        } else {
            return redirect()->route('admin.update.show', compact('round'));
        }
        die();
    }

    public function exportRankings($round)
    {
        $bxh = DB::table('ketqua')
            ->join('doibong', 'doibong.id', '=', 'ketqua.doibong_id')
            ->selectRaw('doibong_id,
            count(CASE WHEN status = 1 THEN 1 ELSE NULL END) as thang,
            count(CASE WHEN status = 0 THEN 1 ELSE NULL END) as hoa,
            count(CASE WHEN status = -1 THEN 1 ELSE NULL END) as thua,
            (count(CASE WHEN status = 1 THEN 1 ELSE NULL END)*3 + count(CASE WHEN status = 0 THEN 1 ELSE NULL END)*1) as tongso,
            sum(banthang) as banthang,
            sum(banthua) as banthua,
            (sum(banthang)-sum(banthua)) as hieuso')
            ->orderBy('tongso', 'DESC')
            ->orderBy('hieuso', 'DESC')
            ->orderBy('doibong.name', 'ASC')
            ->groupBy('doibong_id')->get();

        $tot_record_found = 0;
        if (count($bxh)) {
            $tot_record_found = 1;
            //First Methos
            $export_data = "Position,Club,Number Match,Won,Drawn,Lost,GF,GA,GD,Points\n";
            foreach ($bxh as $key => $val) {
                $export_data .= ($key + 1) . ',' . getNameClub($val->doibong_id) . ',' . numberMatch($val->doibong_id) .
                ',' . $val->thang . ',' . $val->hoa . ',' . $val->thua . ',' . $val->banthang . ',' .
                $val->banthua . ',' . $val->hieuso . ',' . $val->tongso . "\n";
            }
            return response($export_data)
                ->header('Content-Type', 'application/csv')
                ->header('Content-Disposition', 'attachment; filename="Rankings.csv"')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        } else {
            return redirect()->route('admin.update.show', compact('round'));
        }

        die();
    }
}
