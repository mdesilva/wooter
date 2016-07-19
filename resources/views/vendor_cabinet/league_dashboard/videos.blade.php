@extends('landing.layout.page')

@section('Main')

<div class='main' ng-controller='scheduleCtrl' ng-cloak>
	<div class="md-whiteframe-2dp">
	<!-- Main Page stuff -->
		<div layout='column' layout-align="start center"  class="hero_header">
			<!-- Dummy Stuff for now -->
			<div layout='column' class='leagueHead' layout-align="start start">
				<h3 class="">Dream Leagues Elite 8.5</h3>
				<p>Fall 2016</p>
			</div>
		</div>
		<div layout="row" ng-controller="tabsCtrl" class="main_tabs" style="background-color: #024F7E;" layout-align="center center">
			<md-tabs flex class="vendor_tabs" md-no-pagination="false" md-stretch-tabs="never">
				<md-tab ng-repeat="tab in tabs" label="@{{tab.name}}"></md-tab>
			</md-tabs>
		</div>
	</div>
   	<div style='min-height: 100vh'> 
		<div class="sales_innards container md-whiteframe-4dp" ng-controller='scheduleCtrl'>
			<div class="pages_ndots">
				<div class="pages"><p>Videos</p></div>
			</div>
			<div class="pages_search">
				<div class="player_drops">
					<p class='toggle_dropdown'>Entire League &nbsp;&nbsp;&nbsp; <i class="fa fa-caret-down"></i></p>
					<div class="player_menu md-whiteframe-2dp hide">
						<ul>
							<a href="#"><li>Division 1</li></a>
							<a href="#"><li>Division 2</li></a>
							<a href="#"><li>Division 3</li></a>
							<a href="#"><li>Division 4</li></a>
						</ul>
					</div>	
				</div>
				<div class="player_drops">
					<p class='toggle_dropdown'>Week 1 (Feb 1- Feb 8) &nbsp;&nbsp;&nbsp; <i class="fa fa-caret-down"></i></p>
					<div class="player_menu md-whiteframe-2dp hide">
						<ul>
							<a href="#"><li>Division 1</li></a>
							<a href="#"><li>Division 2</li></a>
							<a href="#"><li>Division 3</li></a>
							<a href="#"><li>Division 4</li></a>
						</ul>
					</div>	
				</div>

				<div class="player_search">
					
				</div>
				<div class="player_add">
					
				<p class="md-secondary md-accent new_teambtn red" ng-click="createVideo($event)"><i class="fa fa-plus"></i>&nbsp; ADD VIDEO(S)</md-button>
				</p>

				</div>
			</div>
			<div class="player_results" >
				<div class="photos">
					<div class="limit">
						<div class="images">
							<img class='results' src="" alt="">
							<div class="hovering">
								<p class='play'><i class="fa fa-play"></i></p>
								<p class='delete'>X</p>											
							</div>							
						</div>
						<div class="images">
							
						</div>
						<div class="images">
							
						</div>
						<div class="images">
							
						</div>
						<div class="images">
							
						</div>
						<div class="images">
							
						</div>
						<div class="images">
							
						</div>	
					</div>
				</div>

			</div>
		</div>
	</div>   
</div>
@include('vendor_cabinet.league_dashboard.JavaScript_Links')
<script>
$( document ).ready(function() {
	$('md-tabs-canvas').addClass('container');
	$('.toggle_dropdown').click(function(){
		$( '.player_menu' ).toggleClass('hide');
	});
});






	'use strict';

	;( function ( document, window, index )
	{
		// feature detection for drag&drop upload
		var isAdvancedUpload = function()
			{
				var div = document.createElement( 'div' );
				return ( ( 'draggable' in div ) || ( 'ondragstart' in div && 'ondrop' in div ) ) && 'FormData' in window && 'FileReader' in window;
			}();


		// applying the effect for every form
		var forms = document.querySelectorAll( '.box' );
		Array.prototype.forEach.call( forms, function( form )
		{
			var input		 = form.querySelector( 'input[type="file"]' ),
				label		 = form.querySelector( 'label' ),
				errorMsg	 = form.querySelector( '.box__error span' ),
				restart		 = form.querySelectorAll( '.box__restart' ),
				droppedFiles = false,
				showFiles	 = function( files )
				{
					label.textContent = files.length > 1 ? ( input.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', files.length ) : files[ 0 ].name;
				},
				triggerFormSubmit = function()
				{
					var event = document.createEvent( 'HTMLEvents' );
					event.initEvent( 'submit', true, false );
					form.dispatchEvent( event );
				};

			// letting the server side to know we are going to make an Ajax request
			var ajaxFlag = document.createElement( 'input' );
			ajaxFlag.setAttribute( 'type', 'hidden' );
			ajaxFlag.setAttribute( 'name', 'ajax' );
			ajaxFlag.setAttribute( 'value', 1 );
			form.appendChild( ajaxFlag );

			// automatically submit the form on file select
			input.addEventListener( 'change', function( e )
			{
				showFiles( e.target.files );

				
				triggerFormSubmit();

				
			});

			// drag&drop files if the feature is available
			if( isAdvancedUpload )
			{
				form.classList.add( 'has-advanced-upload' ); // letting the CSS part to know drag&drop is supported by the browser

				[ 'drag', 'dragstart', 'dragend', 'dragover', 'dragenter', 'dragleave', 'drop' ].forEach( function( event )
				{
					form.addEventListener( event, function( e )
					{
						// preventing the unwanted behaviours
						e.preventDefault();
						e.stopPropagation();
					});
				});
				[ 'dragover', 'dragenter' ].forEach( function( event )
				{
					form.addEventListener( event, function()
					{
						form.classList.add( 'is-dragover' );
					});
				});
				[ 'dragleave', 'dragend', 'drop' ].forEach( function( event )
				{
					form.addEventListener( event, function()
					{
						form.classList.remove( 'is-dragover' );
					});
				});
				form.addEventListener( 'drop', function( e )
				{
					droppedFiles = e.dataTransfer.files; // the files that were dropped
					showFiles( droppedFiles );

					
					triggerFormSubmit();

									});
			}


			// if the form was submitted
			form.addEventListener( 'submit', function( e )
			{
				// preventing the duplicate submissions if the current one is in progress
				if( form.classList.contains( 'is-uploading' ) ) return false;

				form.classList.add( 'is-uploading' );
				form.classList.remove( 'is-error' );

				if( isAdvancedUpload ) // ajax file upload for modern browsers
				{
					e.preventDefault();

					// gathering the form data
					var ajaxData = new FormData( form );
					if( droppedFiles )
					{
						Array.prototype.forEach.call( droppedFiles, function( file )
						{
							ajaxData.append( input.getAttribute( 'name' ), file );
						});
					}

					// ajax request
					var ajax = new XMLHttpRequest();
					ajax.open( form.getAttribute( 'method' ), form.getAttribute( 'action' ), true );

					ajax.onload = function()
					{
						form.classList.remove( 'is-uploading' );
						if( ajax.status >= 200 && ajax.status < 400 )
						{
							var data = JSON.parse( ajax.responseText );
							form.classList.add( data.success == true ? 'is-success' : 'is-error' );
							if( !data.success ) errorMsg.textContent = data.error;
						}
						else alert( 'Error. Please, contact the webmaster!' );
					};

					ajax.onerror = function()
					{
						form.classList.remove( 'is-uploading' );
						alert( 'Error. Please, try again!' );
					};

					ajax.send( ajaxData );
				}
				else // fallback Ajax solution upload for older browsers
				{
					var iframeName	= 'uploadiframe' + new Date().getTime(),
						iframe		= document.createElement( 'iframe' );

						$iframe		= $( '<iframe name="' + iframeName + '" style="display: none;"></iframe>' );

					iframe.setAttribute( 'name', iframeName );
					iframe.style.display = 'none';

					document.body.appendChild( iframe );
					form.setAttribute( 'target', iframeName );

					iframe.addEventListener( 'load', function()
					{
						var data = JSON.parse( iframe.contentDocument.body.innerHTML );
						form.classList.remove( 'is-uploading' )
						form.classList.add( data.success == true ? 'is-success' : 'is-error' )
						form.removeAttribute( 'target' );
						if( !data.success ) errorMsg.textContent = data.error;
						iframe.parentNode.removeChild( iframe );
					});
				}
			});


			// restart the form if has a state of error/success
			Array.prototype.forEach.call( restart, function( entry )
			{
				entry.addEventListener( 'click', function( e )
				{
					e.preventDefault();
					form.classList.remove( 'is-error', 'is-success' );
					input.click();
				});
			});

			// Firefox focus bug fix for file input
			input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
			input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });

		});
	}( document, window, 0 ));

</script>

@stop