@extends('landing.layout.page')
@section('Main')

<div class="hero_image">
	<div class="hero_text">
		<img src="/img/landings/schedule.png" alt="">
		<h1>Request A FREE Demo</h1>
	</div>
</div>

<div class="white_space space_one">
	<div class="white_popup md-whiteframe-4dp strategy popup_one">
		<div class="white_half">
			<div class="white_left">		
				<div class="pricing_text">
					<h1>Wooter has everything you need to</h1>
					<h1 class='secondary_h1'>manage and grow your league</h1>
					<div class='custom_hr'></div>		
				</div>

				<div class="pricing_image_center">
					<img data-toggle="modal" data-target="#myModal" src="/img/landings/video_thumbnail.png" alt="">
				</div>
			</div>
			<div class="separator"></div>
			<div class="white_right">

				<div class="pricing_text">
					<h1>Just fill out this form</h1>
					<h1 class='secondary_h1'>and we'll get back to you shortly</h1>
					<div class='custom_hr'></div>		
				</div>

				<form name="colorForm">
					<div class="selection">
						<input class='name_input' name='name' type="text">
						<label class='name_label' for="name">Your Name</label>		
					</div>

					<div class="selection">
						<input class='name_input' name='name' type="text">
						<label class='name_label' for="name">Email Address</label>		
					</div>

					<div class="selection">
						<input class='name_input' name='name' type="text">
						<label class='name_label' for="name">Phone Number</label>		
					</div>

					<div class="selection">
						<input class='name_input' name='name' type="text">
						<label class='name_label' for="name">Comments</label>		
					</div>
					
					<button class='yellow_btn md-whiteframe-4dp' type='submit'>Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>

@stop

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="top: 40%;left: 50%;position: fixed;transform: translate(-50%, -45%);width: 720px;">
    <div class="modal-content">
		<iframe width="720" height="405" src="https://www.youtube.com/embed/SA2q1L35vV0" frameborder="0" allowfullscreen></iframe>
    </div>
  </div>
</div>