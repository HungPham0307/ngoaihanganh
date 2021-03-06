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
			
			<h4 style="margin-left: 37%; color: red;">
				
				@if(Session::has("msg"))
				{{Session::get("msg")}}
				@endif
			</h4>			
		</div>
		<div class="col-md-6" style="width: 100%;">
			<div class="card">
				<h3 class="card-title">Infomation</h3>
				<div class="card-body">
					<form action="{{route('admin.referee.postadd')}}" method="post" enctype="multipart/form-data"  >
						{{csrf_field()}}
						<div class="form-group">
							<label class="control-label">UserName *</label>
							<input type="text" name="username"  class="form-control border-input" placeholder="Enter Username" value="" required>
						</div>

						@if ($errors->has('username'))
						<span style="color: red;">{{ array_first($errors->get('username')) }}</span>
						@endif

						<div class="form-group">
							<label class="control-label">FullName *</label>
							<input class="form-control" type="text" placeholder=" Enter fullname" required name="fullname" value="">
						</div>

						@if ($errors->has('fullname'))
						<span style="color: red;">{{ array_first($errors->get('fullname')) }}</span>
						@endif

            <div class="form-group">
              <label class="control-label">Address *</label>
              <input class="form-control" type="text" placeholder="" required name="address" value="">
            </div>

            @if ($errors->has('address'))
            <span style="color: red;">{{ array_first($errors->get('address')) }}</span>
            @endif

            <div class="form-group">
              <label class="control-label">Email *</label>
              <input class="form-control" type="email" placeholder=" Enter email" required name="email" value="">
            </div>

            <h4 style="margin-left: 37%; color: red;">
              @if(Session::has("email"))
                {{Session::get("email")}}
              @endif
            </h4>

            <div class="form-group">
              <label class="control-label">Birthday *</label>
              <input style="width: 28%;" class="form-control" type="date" required name="birthday" value="">
            </div>

            <h4 style="margin-left: 37%; color: red;">
              @if(Session::has("birthday"))
                {{Session::get("birthday")}}
              @endif
            </h4>
            <div class="form-group">
              <label class="control-label">Position</label>
              <select name="position">
                <option value="1" >Referee</option>
                <option value="2" >Linesman</option>
                <option value="3" >Referee's assistant</option>
              </select>
            </div>

            <h4 style="margin-left: 37%; color: red;">
              @if(Session::has("position"))
                {{Session::get("position")}}
              @endif
            </h4>

            <div class="form-group">
              <label class="control-label">Detail *</label>
              <textarea name="chitiet"  rows="7" cols="90" class="input-medium" style="width: 100%;" required ></textarea>
            </div>

            <h4 style="margin-left: 37%; color: red;">
              @if(Session::has("chitiet"))
                {{Session::get("chitiet")}}
              @endif
            </h4>
            <div class="form-group">
              <label class="control-label">Picture *</label>
              <input class="form-control" type="file" name="hinhanh" style="width: 30%;"  >
            </div>
            <h4 style="margin-left: 37%; color: red;">
              @if(Session::has("hinhanh"))
                {{Session::get("hinhanh")}}
              @endif
            </h4>
            <div class="card-footer">
             <button class="btn btn-primary icon-btn" name="smeditDM" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Add</button>
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