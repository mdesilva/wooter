@extends('landing.layout.page')
@section('Main')

<div class="hero_image">
	<div class="hero_text">
		<h1>Custom Sports Apparel</h1>
		<p>Get the highest quality league apparel <br> at unbeatable prices.</p>
		<button class="yellow_btn md-whiteframe-4dp" data-toggle="modal" data-target="#myModal"><i class="fa fa-play-circle" aria-hidden="true"></i> Watch Video</button>
	</div>
</div>

<div class="black_space">
	<div class="black_popup commissioners">
		<div class="red_pics">
			<div class="image">
				<img src="/img/landings/quality.png" alt="">
			</div>
			<div class="faq">
				<p>Professional Quality</p>
			</div>			
		</div>
		<div class="red_pics">
			<div class="image">
				<img src="/img/landings/delivery.png" alt="">
			</div>
			<div class="faq">
				<p>Fast Delivery</p>
			</div>			
		</div>
		<div class="red_pics">
			<div class="image">
				<img src="/img/landings/moneybags.png" alt="">
			</div>
			<div class="faq">
				<p>Low Prices</p>
			</div>			
		</div>
		<div class="clear"></div>
	</div>
</div>

<div class="white_space space_one">
	<div class="white_popup md-whiteframe-4dp strategy popup_one" '>
		<div class="pricing_text">
			<h1>Basketball, Soccer & Volleyball</h1>
			<div class='custom_hr'></div>
		</div>
		<div class="selection_4">
			<div class="jersey">
				<div class="image">
					<img src="/img/landings/apparel-shirt.png" alt="">
				</div>
				<div class="text">
					<h1>Embroided Jerseys</h1>
					<div class="custom_hr"></div>
					<p>$29.99</p>
				</div>
			</div>
			<div class="jersey">
				<div class="image">
					<img src="/img/landings/apparel-shirt.png" alt="">
				</div>
				<div class="text">
					<h1>Embroided Jerseys</h1>
					<div class="custom_hr"></div>
					<p>$29.99</p>
				</div>
			</div>
			<div class="jersey">
				<div class="image">
					<img src="/img/landings/apparel-shirt.png" alt="">
				</div>
				<div class="text">
					<h1>Embroided Jerseys</h1>
					<div class="custom_hr"></div>
					<p>$29.99</p>
				</div>
			</div>
			<div class="jersey">
				<div class="image">
					<img src="/img/landings/apparel-shirt.png" alt="">
				</div>
				<div class="text">
					<h1>Embroided Jerseys</h1>
					<div class="custom_hr"></div>
					<p>$29.99</p>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>

<div class="white_space space_two">
	<div class="white_popup md-whiteframe-4dp strategy splits popup_two">
		<div class="pricing_text">
			<h1>Baseball & Softball Tops</h1>
			<div class='custom_hr'></div>
		</div>
		<div class="selection_3">
			<div class="jersey">
				<div class="image">
					<img src="/img/landings/apparel-shirt.png" alt="">
				</div>
				<div class="text">
					<h1>Embroided Jerseys</h1>
					<div class="custom_hr"></div>
					<p>$29.99</p>
				</div>
			</div>
			<div class="jersey">
				<div class="image">
					<img src="/img/landings/apparel-shirt.png" alt="">
				</div>
				<div class="text">
					<h1>Embroided Jerseys</h1>
					<div class="custom_hr"></div>
					<p>$29.99</p>
				</div>
			</div>
			<div class="jersey">
				<div class="image">
					<img src="/img/landings/apparel-shirt.png" alt="">
				</div>
				<div class="text">
					<h1>Embroided Jerseys</h1>
					<div class="custom_hr"></div>
					<p>$29.99</p>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>

<div class="white_separator_origin space_three">
	<div class="white_separator_2 popup_three">
		<div class="white_separator_left md-whiteframe-4dp">
			<div class="pricing_text">
				<h1>Football Tops</h1>
				<div class='custom_hr'></div>
			</div>
			<div class="selection_2">
				<div class="jersey">
					<div class="image">
						<img src="/img/landings/apparel-shirt.png" alt="">
					</div>
					<div class="text">
						<h1>Embroided Jerseys</h1>
						<div class="custom_hr"></div>
						<p>$29.99</p>
					</div>
				</div>
				<div class="jersey">
					<div class="image">
						<img src="/img/landings/apparel-shirt.png" alt="">
					</div>
					<div class="text">
						<h1>Embroided Jerseys</h1>
						<div class="custom_hr"></div>
						<p>$29.99</p>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div class="white_separator_right md-whiteframe-4dp">
			<div class="pricing_text">
				<h1>Hockey Tops</h1>
				<div class='custom_hr'></div>
			</div>
			<div class="selection_2">
				<div class="jersey">
					<div class="image">
						<img src="/img/landings/apparel-shirt.png" alt="">
					</div>
					<div class="text">
						<h1>Embroided Jerseys</h1>
						<div class="custom_hr"></div>
						<p>$29.99</p>
					</div>
				</div>
				<div class="jersey">
					<div class="image">
						<img src="/img/landings/apparel-shirt.png" alt="">
					</div>
					<div class="text">
						<h1>Embroided Jerseys</h1>
						<div class="custom_hr"></div>
						<p>$29.99</p>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>
@stop

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="top: 40%;left: 50%;position: fixed;transform: translate(-50%, -45%);width: 720px;">
    <div class="modal-content">
		<iframe width="720" height="405" src="https://www.youtube.com/embed/SA2q1L35vV0" frameborder="0" allowfullscreen></iframe>
    </div>
  </div>
</div>