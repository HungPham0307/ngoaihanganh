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
      <h3 class="add" style="margin-left: 20px;">
          <a href="{{route('admin.player.index', ['id' => $doiBong->id])}}">
            Player
          </a>
        </h3>
			<h4 style="margin-left: 37%; color: red;">
				@if(Session::has("msg"))
				{{Session::get("msg")}}
				@endif
			</h4>
		</div>
		<div class="col-md-6" style="width: 100%;">
			<div class="card">
				<h3 class="card-title"> Infomation Club</h3>
				<div class="card-body">
					<form action="{{route('admin.football.postedit',$doiBong->id)}}" method="post" enctype="multipart/form-data"  >
						{{csrf_field()}}

						@if($doiBong->hinhanh != "")
            <div class="form-group">
              <label>Old picture</label>
              <img src="/files/doibong/{{$doiBong->hinhanh}}" width="120px"/>
            </div>
            <div class="form-group">
             Delete <input type="checkbox" name="delete_picture_club" value="1" />
            </div>
            @endif
            <div class="form-group">
              <label class="control-label">Picture *</label>
              <input class="form-control" type="file" name="hinhanh" style="width: 30%;"  >
            </div>
            <h4 style="margin-left: 37%; color: red;">
              @if(Session::has("hinhanh"))
                {{Session::get("hinhanh")}}
              @endif
            </h4>

            <div class="form-group">
              <label class="control-label">Name *</label>
              <input type="text" name="name_club"  class="form-control border-input" placeholder="Tên user" value="{{$doiBong->name}}" required>
            </div>

            <h4 style="margin-left: 37%; color: red;">
              @if(Session::has("name_club"))
                {{Session::get("name_club")}}
              @endif
            </h4>

            <div class="form-group">
              <label class="control-label">Website *</label>
              <input class="form-control" type="url" placeholder=" Enter link website" required name="link" value="{{ $doiBong->website }}">
            </div>

            <h4 style="margin-left: 37%; color: red;">
              @if(Session::has("link"))
                {{Session::get("link")}}
              @endif
            </h4>

            <div class="form-group">
              <label class="control-label">Address *</label>
              <input class="form-control" type="text" placeholder="" required name="address" value="{{$doiBong->diachi}}">
            </div>

            @if ($errors->has('address'))
            <span style="color: red;">{{ array_first($errors->get('address')) }}</span>
            @endif

            <div class="form-group">
              <label class="control-label">Email *</label>
              <input class="form-control" type="email" placeholder=" Enter email" required name="email" value="{{$doiBong->email}}">
            </div>

            <h4 style="margin-left: 37%; color: red;">
              @if(Session::has("email"))
                {{Session::get("email")}}
              @endif
            </h4>

            <div class="form-group">
              <label class="control-label" > The club was founded *</label>
              <input style="width: 28%;" class="form-control" type="date" required name="birthday" value="{!! date('Y-m-d', strtotime($doiBong->ngaythanhlap))!!}">
            </div>

            <h4 style="margin-left: 37%; color: red;">
              @if(Session::has("birthday"))
                {{Session::get("birthday")}}
              @endif
            </h4>
            <div class="form-group">
              <label class="control-label">Detail *</label>
              <textarea name="chitiet"  rows="7" cols="90" class="input-medium" style="width: 100%;" required > {{$doiBong->chitiet}}</textarea>
            </div>

            <h4 style="margin-left: 37%; color: red;">
              @if(Session::has("chitiet"))
                {{Session::get("chitiet")}}
              @endif
            </h4>

            <h3 class="card-title"> Infomation Stadium</h3>

            <div class="form-group">
              <label class="control-label">Name Stadium *</label>
              <input type="text" name="name_stadium"  class="form-control border-input" placeholder="Enter name stadium" value="{{ $doiBong->sanVanDong->name }}" required>
            </div>

            <h4 style="margin-left: 37%; color: red;">
              @if(Session::has("name_stadium"))
                {{Session::get("name_stadium")}}
              @endif
            </h4>

            <div class="form-group">
              <label class="control-label">Total number :  *</label>
              <input type="number" name="total_number"  class="form-control border-input" placeholder="Enter total number" value="{{ $doiBong->sanVanDong->suc_chua }}" required>
            </div>

            <h4 style="margin-left: 37%; color: red;">
              @if(Session::has("total_number"))
                {{Session::get("total_number")}}
              @endif
            </h4>

            @if($doiBong->sanVanDong->hinhanh != "")
            <div class="form-group">
              <label>Picture stadium : *</label>
              <img src="/files/sanvandong/{{ $doiBong->sanVanDong->hinhanh }}" width="120px" />
            </div>
            <div class="form-group">
              Delete <input type="checkbox" name="delete_picture_stadium" value="1" />
            </div>
            @endif
            <div class="form-group">
              <label class="control-label">Change Picture *</label>
              <input class="form-control" type="file" name="picutre_stadium" style="width: 30%;"  >
            </div>
            <h4 style="margin-left: 37%; color: red;">
              @if(Session::has("picutre_stadium"))
                {{Session::get("picutre_stadium")}}
              @endif
            </h4>

            <div class="form-group">
              <label class="control-label">Detail *</label>
              <textarea name="detail_stadium"  rows="7" cols="90" class="input-medium" style="width: 100%;" required >{{ $doiBong->sanVanDong->chitiet}}</textarea>
            </div>

            <h4 style="margin-left: 37%; color: red;">
              @if(Session::has("detail_stadium"))
                {{Session::get("detail_stadium")}}
              @endif
            </h4>

            <div class="card-footer">
             <button class="btn btn-primary icon-btn" name="smeditDM" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Ok</button>
           </div>
         </form>
       </div>

     </div>
   </div>
 </div>
</div>
</body>
</html>
@stop
