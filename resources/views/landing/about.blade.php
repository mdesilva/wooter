@extends('landing.layout.page')
@section('Main')

<div class="hero_image">
	<div class="hero_text">
		<h1>About Us</h1>
		<p>We are athletes and league owners <br>
		raising the standard for recreational sports.</p>
	</div>
</div>

<div class="black_space">
	<div class="black_popup commissioners">
		<div class="image">
			<img src="/img/landings/man.png" alt="">
		</div>
		<div class="faq">
			<p>FAQ - Commissioners</p>
		</div>
	</div>
</div>

<div class="white_space space_one">
	<div class="white_popup md-whiteframe-4dp accordions popup_one">

		<div class="tab">
			<div class="question">
				<img class='plus_minus' src="/img/landings/plus.png" alt="">
				<img class='plus_minus hide' src="/img/landings/minus.png" alt="">
				<p>What services does Wooter provide to leagues?</p>
			</div>			
			<div class="answer hide">
	            <p>Wooter provides league owners with all of the tools they need to start, run, manage, advertise and expand their leagues all in one place.</p><br>
	            <p style='font-weight: bold; text-decoration:underline;'>Marketplace</p>
	            <p>League organizers can create a page for their league that lists all their season 
	               information, photos, unique features etc. This page will show up on Wooter's search 
	               marketplace when players are looking for a league in their area. Players will then be 
	               able to register, invite their friends to join their team, and pay.</p><br>
	            <p style='font-weight: bold; text-decoration:underline;'>League Management</p>
	            <p>Wooter offers a management solution, valued at $1499, for FREE to all league partners.
	               This management solution allows league organizers to manage and run their league all in
	               one place. The management solution includes:</p><br>
	                    
	            <ul style='padding-left: 40px;'>
	              <li>Managing rosters</li>
	              <li>A scheduling system</li>
	              <li>Managing team and free agent registration</li>
	              <li>Broadcasting messages to the entire league</li>
	              <li>Real time updates to keep track of payments</li>
	              <li>Sending texts and emails to individual teams and players.</li>
	            </ul><br>

	            <p>For more information on Wooter's management software, please <a href='/demo'>schedule a demo.</a></p><br>
	            <p style='font-weight: bold; text-decoration:underline;'>Dream Leagues Services</p>
	            <p>Dream Leagues Services help league players feel like pros! These services are designed to bring leagues to a new level, to enhance the experience for current players and to help leagues grow by attracting new ones. League services include stat tracking, player interviews, video highlights, top 10 plays, game recaps, power rankings and much more!</p><br>
	            <p>For more information on Dream League Service packages, see our <a href='/packages'>Packages page.</a></p>
			</div>
		</div>

		<div class="tab">
			<div class="question">
				<img class='plus_minus' src="/img/landings/plus.png" alt="">
				<img class='plus_minus hide' src="/img/landings/minus.png" alt="">
				<p>Is there a processing or transaction fee for registrations?</p>
			</div>			
			<div class="answer hide">
				<p>Yes, there is a fee that Paypal charges for each transaction (2.9% + 30 cents).
	               We do not take any percentage on top of the processing fees. The balance that 
	               appears on your Wooter dashboard will be after the processing fees are subtracted.</p>
			</div>
		</div>

		<div class="tab">
			<div class="question">
				<img class='plus_minus' src="/img/landings/plus.png" alt="">
				<img class='plus_minus hide' src="/img/landings/minus.png" alt="">
				<p>How do I list my league on Wooter?</p>
			</div>			
			<div class="answer hide">
            	<p>In order to be listed on Wooter's marketplace, use the league management 
	               software or use any Dream Leagues Service, you need to <a href="/contact">contact us</a>. We suggest that you <a href="/demo">schedule a demo</a> so we can walk you through everything and tailor our services to your needs. You can also call us at (347) 850-2720 
	               or send an email to vip@wooter.co. </p>
			</div>
		</div>


		<div class="tab">
			<div class="question">
				<img class='plus_minus' src="/img/landings/plus.png" alt="">
				<img class='plus_minus hide' src="/img/landings/minus.png" alt="">
				<p>What if some customers hand me cash?</p>
			</div>			
			<div class="answer hide">
	            <p>You will be able to manually add them into the management system 
	               together with all your online registrants. However to save you the hassle, 
	               you should probably tell them to register online next time because it will 
	               be much easier to keep track of all your payments.</p>
			</div>
		</div>


		<div class="tab">
			<div class="question">
				<img class='plus_minus' src="/img/landings/plus.png" alt="">
				<img class='plus_minus hide' src="/img/landings/minus.png" alt="">
				<p>How can I control what appears on my League Page?</p>
			</div>			
			<div class="answer hide">
	            <p>You have full control over your league page. Once we set up a page for
	               your league, you will be given login information. That information allows 
	               you to manage the information on your page, use our management solution, 
	               see how many players have registered for your league, and access to Dream 
	               Leagues Services.</p>
			</div>
		</div>


		<div class="tab">
			<div class="question">
				<img class='plus_minus' src="/img/landings/plus.png" alt="">
				<img class='plus_minus hide' src="/img/landings/minus.png" alt="">
				<p>What should I do if I am busy, but need to update my league page on Wooter?</p>
			</div>			
			<div class="answer hide">
	            <p>We understand that running a league is extremely time consuming. 
	               That’s why we assign each league an Account Manager to help maintain their account. 
	               You can edit any information yourself, or you can always contact your assigned 
	               Account Manager and they can update anything you need for you.</p>
			</div>
		</div>

		<div class="tab">
			<div class="question">
				<img class='plus_minus' src="/img/landings/plus.png" alt="">
				<img class='plus_minus hide' src="/img/landings/minus.png" alt="">
				<p>How will I receive payments from all of the player registrations?</p>
			</div>			
			<div class="answer hide">
	            <p>We’re integrated with the Braintree Marketplace
	               (a Paypal company) that allows all the payments to be 
	               collected in an escrow account. You can then withdraw via Paypal or check.</p>
			</div>
		</div>
	</div>
</div>

<div class="black_space">
	<div class="black_popup athletes">
		<div class="image">
			<img src="/img/landings/basketball.png" alt="">
		</div>
		<div class="faq">
			<p>FAQ - Athletes</p>
		</div>
	</div>
</div>

<div class="white_space space_two">
	<div class="white_popup md-whiteframe-4dp accordions popup_two">

		<div class="tab">
			<div class="question">
				<img class='plus_minus' src="/img/landings/plus.png" alt="">
				<img class='plus_minus hide' src="/img/landings/minus.png" alt="">
				<p>If I don’t have enough players for a full team, can I still register for the league?</p>
			</div>			
			<div class="answer hide">
	            <p>Absolutely. You can register as a free agent and the league organizer
	               will place you on a team. If you want to be placed on the same team as 
	               another free agent, you can message the league organizer right on Wooter.</p>
			</div>
		</div>

		<div class="tab">
			<div class="question">
				<img class='plus_minus' src="/img/landings/plus.png" alt="">
				<img class='plus_minus hide' src="/img/landings/minus.png" alt="">
				<p>The sports league that I play in is not on Wooter.</p>
			</div>			
			<div class="answer hide">
	            <p>That’s a shame! Refer your league and your first season is on the house.
	            <a href='/packages'>Learn more.</a></p>
			</div>
		</div>


		<div class="tab">
			<div class="question">
				<img class='plus_minus' src="/img/landings/plus.png" alt="">
				<img class='plus_minus hide' src="/img/landings/minus.png" alt="">
				<p>How do I know if I qualify to play in a league?</p>
			</div>			
			<div class="answer hide">
	            <p>All information about league requirements will be available on
	               the league page. If you have any specific questions, you can also
	               message the league organizer right on Wooter.</p>
			</div>
		</div>


		<div class="tab">
			<div class="question">
				<img class='plus_minus' src="/img/landings/plus.png" alt="">
				<img class='plus_minus hide' src="/img/landings/minus.png" alt="">
				<p>I've never played a specific sport and want to try it out, can I use Wooter to find leagues for beginners?</p>
			</div>			
			<div class="answer hide">
	            <p>When you register as a player, the league will usually ask questions 
	               about any medical conditions. As long as the league is made aware of the
	               condition and can accommodate, you’re good to go!</p>
			</div>
		</div>


		<div class="tab">
			<div class="question">
				<img class='plus_minus' src="/img/landings/plus.png" alt="">
				<img class='plus_minus hide' src="/img/landings/minus.png" alt="">
				<p>I have a medical condition, can I still join a league?</p>
			</div>			
			<div class="answer hide">
				<p>Yes you can. However, you should talk to the owner of the league you want to join and express your medical condition. Communication between you and the owner is essential to a smooth league experience.</p>
			</div>
		</div>

		<div class="tab">
			<div class="question">
				<img class='plus_minus' src="/img/landings/plus.png" alt="">
				<img class='plus_minus hide' src="/img/landings/minus.png" alt="">
				<p>Once I pay to join the league, how do I know my transaction went through?</p>
			</div>			
			<div class="answer hide">
	            <p>You will receive an email with your billing receipt and the money will 
	               be taken from your account by “Wooter LLC.”</p>
			</div>
		</div>
	</div>
</div>


@stop
