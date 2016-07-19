<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Hello! You have been added to the team {{ $team->name }} at Wooter.</div>
				<div class="panel-body">
                    Check it out, {{ $player->first_name }}!
                    <a href="{{ url('/team/'.$team->id) }}">{{ $team->name }}</a>
				</div>
			</div>
		</div>
	</div>
</div>
