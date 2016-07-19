@include('snapgrow.layout.head')
@include('snapgrow.layout.header')

<div class="hero_image">
	<div class="hero_text">
		<h1>Submit a consultation request.</h1>
		<p>From start to finish we’ll guide you <br>
		through your social media sales journey.</p>
	</div>
</div>

<div class="white_space space_one">
	<div class="white_popup md-whiteframe-4dp strategy popup_one">
		<div class="white_half">
			
			<div class="white_left">		
				<div class="pricing_text">
					<h1>Need a little more convincing?</h1>
					<div class='custom_hr'></div>
					<p>Call us for a free 15 minute consultation! What you may expect from a consultation:</p>
					<ul>
						<li>Strategic advice on social media marketing</li><br>
						<li>Overview of your performance on Instagram and Twitter</li><br>
						<li>How to break through any marketing plateaus you may have reached</li><br>
						<li>Answering any questions you may have about Snapgrow Media</li>
					</ul>		
				</div>

				<div class="pricing_image_center">
					<img src="/img/snapgrow/how-works2.png" alt="">
					<p class='social_label'>Phone:</p>
					<p>(646) 401-1339</p>
				</div>
			</div>
			<div class="separator"></div>
			<div class="white_right">

				<div class="pricing_text">
					<h1>Before we setup a call we need <br>
					to know a few things about you:</h1>
					<div class='custom_hr'></div>		
				</div>

				<form name="colorForm">
					<div class="selection">
						<input class='name_input' name='name' type="text">
						<label class='name_label' for="name">Organization Name</label>		
					</div>

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
						<label class='name_label' for="name">Intagram Handle <span style='font-size: 50%;'>(optional)</span></label>		
					</div>

					<div class="selection">
						<input class='name_input' name='name' type="text">
						<label class='name_label' for="name">Twitter Handle <span style='font-size: 50%;'>(optional)</span></label>		
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
          	<p>Ready to take control of your social media sales?</p>
			<p><a href="/snapgrow/pricing"><button class="yellow_btn md-whiteframe-4dp">View Prices</button></a></p>
		</div>
	</div>
</div>

@include('snapgrow.layout.footer')