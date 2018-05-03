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
				<h3 class="card-title">Club</h3>
				<div class="card-body">
					<form action="{{route('admin.football.postadd')}}" method="post" enctype="multipart/form-data"  >
						{{csrf_field()}}
						<div class="form-group">
							<label class="control-label">Name Club *</label>
							<input type="text" name="name_club"  class="form-control border-input" placeholder="Enter name club" value="" required style="width: 28%;">
						</div>

						<h4 style="margin-left: 37%; color: red;">
              @if(Session::has("name_club"))
                {{Session::get("name_club")}}
              @endif
            </h4>

						<div class="form-group">
							<label class="control-label">Website *</label>
							<input class="form-control" type="url" placeholder=" Enter link website" required name="link" value="" style="width: 28%;">
						</div>

						<h4 style="margin-left: 37%; color: red;">
              @if(Session::has("link"))
                {{Session::get("link")}}
              @endif
            </h4>
            <div class="form-group">
              <label class="control-label">Email *</label>
              <input class="form-control" type="email" placeholder=" Enter email" required name="email" value="" style="width: 28%;">
            </div>

            <h4 style="margin-left: 37%; color: red;">
              @if(Session::has("email"))
                {{Session::get("email")}}
              @endif
            </h4>

            <div class="form-group">
              <label class="control-label">The club was founded  *</label>
              <input style="width: 28%;" class="form-control" type="date" required name="date" value="">
            </div>

            <h4 style="margin-left: 37%; color: red;">
              @if(Session::has("date"))
                {{Session::get("date")}}
              @endif
            </h4>

            <div class="form-group">
              <label class="control-label">Picture club :  *</label>
              <input class="form-control" type="file" name="hinhanh" style="width: 28%;"  >
            </div>

            <div class="form-group">
              <label class="control-label">Address *</label>
              <input class="form-control" type="text" placeholder="" required name="address" value="" style="width: 50%;">
            </div>

            <h4 style="margin-left: 37%; color: red;">
              @if(Session::has("address"))
                {{Session::get("address")}}
              @endif
            </h4>

             <div class="form-group" style="width: 50%;">
              <label class="control-label">Detail *</label>
              <textarea name="chitiet"  rows="7" cols="90" class="input-medium" style="width: 100%; border: 2px solid #ccc;" required ></textarea>
            </div>

            <h4 style="margin-left: 37%; color: red;">
              @if(Session::has("chitiet"))
                {{Session::get("chitiet")}}
              @endif
            </h4>


            <div class="form-group">
              <h3 class="card-title">Stadium</h3>
            </div>

            <div class="form-group">
              <label class="control-label">Name Stadium *</label>
              <input type="text" name="name_stadium"  class="form-control border-input" placeholder="Enter name stadium" value="" required style="width: 28%;">
            </div>

            <h4 style="margin-left: 37%; color: red;">
              @if(Session::has("name_stadium"))
                {{Session::get("name_stadium")}}
              @endif
            </h4>

            <div class="form-group">
              <label class="control-label">Total number :  *</label>
              <input type="number" name="total_number"  class="form-control border-input" placeholder="Enter total number" value="" required style="width: 28%;">
            </div>

            <h4 style="margin-left: 37%; color: red;">
              @if(Session::has("total_number"))
                {{Session::get("total_number")}}
              @endif
            </h4>

            <div class="form-group">
              <label class="control-label">Picture stadium : *</label>
              <input class="form-control" type="file" name="picture_stadium" style="width: 28%;"  >
            </div>

            <div class="form-group" style="width: 50%;">
              <label class="control-label">Detail *</label>
              <textarea name="detail_stadium"  rows="7" cols="90" class="input-medium" style="width: 100%;border: 2px solid #ccc;" required ></textarea>
            </div>

            <h4 style="margin-left: 37%; color: red;">
              @if(Session::has("detail_stadium"))
                {{Session::get("detail_stadium")}}
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
