<?php

namespace App\Http\Controllers\Premier;

use App\Http\Controllers\Controller;
use App\Model\MuaGiai;
use App\Model\News;
use Carbon\Carbon;
use DB;

class PublicController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->format('Y-m-d');

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

        if (isWeekend($today) == 1) {
            $matchs = MuaGiai::where('date', $today)->with('sanvandong', 'doinha', 'doikhach')->orderBy('date', 'ASC')->orderBy('time', 'ASC')->get();
        } else {
            $matchs = MuaGiai::where('date', '>=', $today)->with('sanvandong', 'doinha', 'doikhach')->orderBy('date', 'ASC')->orderBy('time', 'ASC')->take(10)
                ->get();
        }
        //type = 1 premier
        //type =2 transfer
        $premier_news = News::where('active', 1)->where('type', 1)->get();
        $transfer_news = News::where('active', 1)->where('type', 2)->get();

        return view('public.public.index', compact('bxh', 'matchs', 'premier_news', 'transfer_news'));
    }
}
