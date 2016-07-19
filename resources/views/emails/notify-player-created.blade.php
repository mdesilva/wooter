<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    You have been added to Wooter!
                    Now you need to complete your profile, add a password and get started!</div>
                <div class="panel-body">
                    Hello {{ $player->first_name }},
                    <a href="{{ url('/player/complete-registration/'.$token) }}">Click here to complete your profile</a>
                </div>
            </div>
        </div>
    </div>
</div>
