@extends('templates.admin.master')
@section('main-admin')
<div class="content-wrapper">

  <div class="row user">
    <div class="col-md-12">
      <div class="profile">
        <div class="info"><img class="user-img" src="/templates/admin/images/admin.jpg">
          <h4>
            @if(Session::has("name"))

            {{Session::get("name")}}
            @endif
          </h4>
        </div>
        <div class="cover-image"></div>
      </div>
    </div>
    <div class="page-title">
      <div class="title">
        <h3 class="add" style="width: auto;">
          <a href="{{ route('admin.update.exportResultRound',['round' => $round]) }}">
            Download the round result
          </a>
        </h3>

        <h3 class="add " style="width: auto;">
          <a href="{{route('admin.update.exportRankings',['round' => $round])}}">
            download the rankings
          </a>
        </h3>
      </div>
      <h4 style="margin-left: 37%; color: red;">

        @if(Session::has("msg"))
        {{Session::get("msg")}}
        @endif
      </h4>
    </div>
    <div class="col-md-6" style="width: 100%;">
      <div class="card">
        <h3 class="card-title">Change Infomation</h3>
        <div class="card-body">
          <table class="table" style="width: auto;">
            <thead>
              <tr>
                <th style="text-align: center;" >Round</th>
                <th style="text-align: center;" >Home Team</th>
                <th style="text-align: center;" >Score</th>
                <th style="text-align: center;" >Away Team</th>
                <th style="text-align: center;" >Stadium</th>
                <th style="text-align: center;" >Time</th>
                <th style="text-align: center;" >Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($matchs as $match)
              <tr>
                <form action="{{route('admin.update.update',['id' => $match->id])}}" method="post"  >
                {!! csrf_field() !!}
                <td style="text-align: center;" >{{$match->vongdau}}</td>
                <td style="text-align: center;" >{{$match->doinha->name}}</td>
                <td style="text-align: center;">
                  <input type="number" name="home_goals" min="0" value="{{homeScore($match->doinha_id, $match->vongdau)}}" style="width: 15%; text-align: center;" required> -
                  <input type="number" name="away_goals"  min="0" value="{{awayScore($match->doikhach_id, $match->vongdau)}}" style="width: 15%; text-align: center;" required>
                </td>
                <td style="text-align: center;" >{{$match->doikhach->name}}</td>
                <td style="text-align: center;" >{{$match->sanvandong->name}}</td>
                <td style="text-align: center;" >
                  {{ Carbon\Carbon::parse($match->date)->format('Y/m/d')}} {{ Carbon\Carbon::parse($match->time)->format('H:i') }} PM
                </td>
                <td style="text-align: center;" >
                  <button class="btn btn-primary icon-btn" name="smeditDM" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>
                </td>
              </tr>
              </form>
              @endforeach
            </tbody>
          </table>

          <table class="table" style="width: auto;">
            <thead>
              <tr>
                <th style="text-align: center;" >Position</th>
                <th style="text-align: center;" ></th>
                <th style="text-align: center;" >Club</th>
                <th style="text-align: center;" >Number Match</th>
                <th style="text-align: center;" >Won</th>
                <th style="text-align: center;" >Drawn</th>
                <th style="text-align: center;" >Lost</th>
                <th style="text-align: center;" >GF</th>
                <th style="text-align: center;" >GA</th>
                <th style="text-align: center;" >GD</th>
                <th style="text-align: center;" >Points</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($bxh as $key => $val)
              <tr>
                <td style="text-align: center;" >{{ $key+1 }}</td>
                <td>
                  <img style="width: 20px;height: 20px;" src="/files/doibong/{{ getImageClub($val->doibong_id) }}">
                </td>
                <td style="text-align: center;" >
                  {{ getNameClub($val->doibong_id) }}
                </td>
                <td style="text-align: center;">{{ numberMatch($val->doibong_id) }}</td>
                <td style="text-align: center;" >{{ $val->thang }}</td>
                <td style="text-align: center;" >{{ $val->hoa }}</td>
                <td style="text-align: center;" >{{ $val->thua }}</td>
                <td style="text-align: center;" >{{ $val->banthang }}</td>
                <td style="text-align: center;" >{{ $val->banthua }}</td>
                <td style="text-align: center;" >{{ $val->hieuso }}</td>
                <td style="text-align: center;" >{{ $val->tongso }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
@stop
