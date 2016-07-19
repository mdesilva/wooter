@extends('landing.layout.page')
@include('templates.ui.notify-container')
@section('Main')

<div class="hero_image">
	<div class="hero_text">
		<img src="/img/landings/contact.png" alt="">
		<h1>Contact Us</h1>
	</div>
</div>

<div class="white_space space_one">
	<div class="white_popup md-whiteframe-4dp strategy popup_one">
		<div class="pricing_text">
			<h1>Just fill out this form</h1>
			<h1 class='secondary_h1'>and we'll get back to you shortly</h1>
			<div class='custom_hr'></div>		
		</div>

		<form name="colorForm" ng-submit="submitContact()" ng-controller="ContactController">
			<div class="selection">
				<input class='name_input' name='name' ng-model='contact.name' type="text" required>
				<label class='name_label' for="name">Your Name</label>		
			</div>

			<div class="selection">
				<input class='name_input' name='name' ng-model='contact.email' type="text" required>
				<label class='name_label' for="name">Email Address</label>		
			</div>

			<div class="selection">
				<input class='name_input' name='name' ng-model='contact.phone' type="numeric" mask="(999) 999-9999" required>
				<label class='name_label' for="name">Phone Number</label>		
			</div>

			<div class="selection">
				<input class='name_input' name='name' ng-model='contact.comments' type="text" required>
				<label class='name_label' for="name">Comments</label>		
			</div>
					
			<button class='yellow_btn md-whiteframe-4dp' type='submit'>Submit</button>
		</form>
	</div>
</div>

@stop