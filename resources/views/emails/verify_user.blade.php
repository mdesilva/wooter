<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Verify your account</div>
				<div class="panel-body">
                    Hello {{ $user->first_name }},
                    <a href="{{ url('/#/verify-token/'.$token) }}">Click here to verify your account</a>
					<p>or</p>
					<p><a href="{{ url('/#/verify-token/'.$token) }}">{{ url('/#/verify-token/'.$token) }}</a></p>
				</div>
			</div>
		</div>
	</div>
</div>
