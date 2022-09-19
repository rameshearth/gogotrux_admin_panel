@extends('layouts.app')
<!-- Content Header (Page header) -->
@section('content-header')
	<h1>
		Customer Home
	</h1>
	<ol class="breadcrumb">
		<li><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
		<li class="active">Customer Information Board</li>
	</ol>
@endsection

@section('content')
	<div class="row">
		@if(session('success'))
			<div class="alert alert-success" id="success-message">
				{{ session('success') }}
			</div>
		@endif
		@if(session('error'))
			<div class="alert alert-error" id="fail-message">
				{{ session('error') }}
			</div>
		@endif
		<div class="col-xs-12">
			<div class="box">
				<div class="box-body">
					<h4>
						Customer Information Board Add
					</h4>
					<form method="POST" id="infoBoardForm" name="info_board" action="{{ route ('customerinformationboard.store',['type' => 'informationBoard']) }} ">  
					@csrf
						<div class="row">
							<div class="col-md-6">
								<label for="info_board_text" class="control-label">Customer Information Board Text:</label>
								<textarea type="text" class="form-control" name="info_board_text" id="info_board_text" required></textarea>
							</div>
							<div class="col-md-2">
								<input type="submit" class="btn btn-xs btn-success s-top" value="Submit">
							</div>
						</div> 
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('javascript')
<script language="javascript" type="text/javascript">

	$("#infoBoardForm").validate({
		rules: {
			info_board_text: {
				required: true,	
			}
		},
		messages: {
			info_board_text: {
				required: "Please Enter Customer Information Board",
			}
		},
	});	
</script>

@endsection
