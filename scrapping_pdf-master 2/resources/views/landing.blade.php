<!DOCTYPE html>
<html>
<head>
	<title>UTD Degree Audit</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<style type="text/css">
	body {
		margin: 0;
		overflow-x:hidden;

	}
	.wrapper-main {
		display: flex;
		height: 100vh;
		align-items:center;
		justify-content: center;
		background-color: #d86e38;
		flex-direction: column;

	}

	.logo-image {
		border-radius: 50%;
		width: 200px;
		height: 200px;
	}
	.main-utd-head {
		color: white;
		font-size:80px;
	}

	.description-head {
		color: #fff;
		font-size: 36px;
		padding: 0 30px;
		text-align: center;
	}
	.flex {
		display: flex;

	}

	.main-btn {
		border: none;
		border-radius: 5px;
		color: #fff;
		background-color: #3d6686;
		padding: 30px 40px;
	}

	.ml1 {
		margin-left: 5px;
	}

	.mr1 {
		margin-right: 5px;
	}

	@media(max-width: 768px) {
		.main-utd-head {
		color: white;
		font-size: 40px;
	}
	.description-head {
		font-size: 24px;
		padding: 0 20px;
		
	}
	.main-btn {
		
		padding: 20px 30px;
	}
	}
</style>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="icon" href="{{ URL::asset('public')}}/assets/design/assets/img/landing.png" type="image/gif" sizes="16x16">

</head>
<body>

<div class="wrapper-main">
	<a href="{{URL('/')}}"><img class="logo-image" src="{{ URL::asset('public')}}/assets/design/assets/img/landing.png" alt="logo"/></a>
	<h1 class="main-utd-head">UTD Degree Audit</h1>
	<p class="description-head">Welcome to this free tool, pick the Comet button if you are already a student at UTD or Freshman if you are a new student.</p>
	<div class="flex">

		<a data-toggle="modal" data-target="#exampleModal" style="text-decoration: none;pointer:cursor;" href="" class="main-btn mr1">I am a Comet</a>
		<a style="text-decoration: none;pointer:cursor;" class="main-btn mr1" href="" data-toggle="modal" data-target="#exampleModal2">Future Comet</a>


		<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">UPLOAD YOUR DATA</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<form name="myform2" method="post" action="index.php/parse_pdf" enctype="multipart/form-data">
      	  {!! csrf_field() !!}
	
		  <div class="form-group">
		    <label for="email">NET ID:</label>
		    <input type="text" required="" class="form-control" id="student_id" name="student_id" onkeypress="return blockSpecialChar(event)"/>

		  </div>
		  <div class="form-group">
		    <label for="pwd">File:</label>
		    <input type="file" required="" class="form-control" id="filename" name="filename" accept=".pdf"/>
		  </div>
		  
		  <button type="submit" class="btn btn-default">Submit</button>
		  </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="myform2" method="post" action="index.php/student/freshman" enctype="multipart/form-data">
          {!! csrf_field() !!}
	      <h3>Add a disclaimer for future comets</h3>		
		  <div class="form-group">
		    <label for="email">Phone No.</label>
		    <input type="text" required="" class="form-control" id="student_id2" name="student_id2" onkeypress="return blockSpecialChar(event)"/>
		  </div>
		  
		  <button type="submit" class="btn btn-default">Continue</button>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

</div>
</div>

<script type="text/javascript">
	$('#filename').on( 'change', function() {
	   myfile= $( this ).val();
	   var ext = myfile.split('.').pop();
	   if(ext=="pdf"){
	       //alert(ext);
	   } else{
	       alert('Only pdf allowed');
	       $(this).val("");
	   }
	});

    function blockSpecialChar(e){
        var k;
        document.all ? k = e.keyCode : k = e.which;
        return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
    }
</script>
</body>
</html>