<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Hello from Wooter!
                    You have been requested to join {{$league->name}}.
                    Now you need to answer league questions to join the league!
                </div>
            </div>
            <div class="panel-body">
                <a class="invite-player-url" href="{{ url('/api/leagues/'.$league->id.'/'.$token.'/'.$email.'/join-by-invitation') }}" target="_blank">Click here to answer league questions</a>
            </div>
        </div>
    </div>
</div>
