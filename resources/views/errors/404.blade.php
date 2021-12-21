@extends("front.layouts.layout")
@section("title", "Error | Slate Sign")
@section("page_style")
@endsection
@section("content")
<div id="main">
	<div class="wrapper">
		<div class="error-bg"></div>
		<!-- <div class="illustration"></div> -->
		<div id="error404">
			<h1 class="main-title">Error</h1>
			<!-- <div class="item facebook">
				<a href="#"><span class="link"></span></a>
				<span class="icon"></span>
			</div> -->
				<h1 class="error404_heading" >Sorry This Page Does Not Exist...</h1>

				<h3 class="tag-line">Apologies but we were unable to find what you are looking for.</h3>



			<!-- <div class="item apple">
				<a href="#"><span class="link"></span></a>
				<span class="icon"></span>
				<span class="text">Continue with Apple</span>
			</div>
			<div class="item google">
				<a href="#"><span class="link"></span></a>
				<span class="icon"></span>
				<span class="text">Continue with Google</span>
			</div> -->
			
				<!-- <a class="email-login" href="#"><span class="link"></span></a> -->



				<!-- <div class="content">
				<h3 class="name" >Apologies But We Were Unable TO Find What You Are Looking For.</h3>
			                 </div> -->
			
		<!-- 	<span class="or">or</span> -->
			<div class="item email" style="cursor: pointer;">
				<!-- <a class="email-login" href="#"><span class="link"></span></a> -->
				<span class="visit">Visit Homepage</span>
			</div>
		</div>



	</div>
</div>
@endsection
@section("page_vendors")
@endsection
@section("page_script")
<script type="text/javascript">
	$(".visit").click(function()
	{
		window.location.href = "";
	});
</script>
@endsection