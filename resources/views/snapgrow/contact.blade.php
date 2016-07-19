@include('snapgrow.layout.head')
@include('snapgrow.layout.header')

<div class="hero_image">
	<div class="hero_text">
		<h1>Have a question? Get in touch.</h1>
		<p>Reach your potential customers through social <br>
		media marketing straight from the experts.</p>
	</div>
</div>

<div class="white_space space_one">
	<div class="white_popup md-whiteframe-4dp strategy popup_one">
		<div class="white_half">
			<div class="white_left">		
				<div class="pricing_text">
					<h1>Out Contact Information</h1>
					<div class='custom_hr'></div>		
				</div>

				<div class="pricing_image_center">
					<img src="/img/snapgrow/instagram.png" alt="">
					<p class='social_label'>Email:</p>
					<p>hi@snapgrowmedia.com</p>
					<br><br>


					<img src="/img/snapgrow/instagram.png" alt="">
					<p class='social_label'>Phone:</p>
					<p>(646) 401-1339</p>
				</div>
			</div>
			<div class="separator"></div>
			<div class="white_right">

				<div class="pricing_text">
					<h1>Did you know that Instagram is the <br>
					fastest growing social platform used by <br>
					small to mid- sized businesses?</h1>
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

<div class="black_space">
	<div class="black_popup level followers">
		<div class="build">
          	<p>Ready to take your business to the next level?</p>
			<p><a href="/snapgrow/pricing"><button class="yellow_btn md-whiteframe-4dp">View Prices</button></a></p>
		</div>
	</div>
</div>

@include('snapgrow.layout.footer')