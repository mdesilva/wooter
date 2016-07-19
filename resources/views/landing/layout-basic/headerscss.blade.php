<!-- //HEADER

.wooter_header{
	height: 64px;
	width: 100%;
	background-color: #252525;
	box-shadow: 0px 1px 1px 0px #313131;
	position: relative;
	z-index: 1000;

	.wooter_hamburger{
		position: absolute;
		left: 31px;
		z-index: 2;
		display: none;
		top: 0px;

		@media only screen and (max-width: 959px) {
			display: block!important;
        }

		@media only screen and (max-width: 399px) {
			left: 20px;
        }

		p{
			font-size: 22px;
			height: 64px;
			padding: 23px 0px;
			margin: 0px;
			color: rgba(255,255,255,.6);

			i{
				position: absolute;
				z-index: 10000;
				cursor: pointer;
			}
		}
	}

	.wooter_logo{
		position: absolute;
		left: 31px;
		z-index: 1;

		@media only screen and (max-width: 959px) {
            left: 0px;
            width: 100%;
        }
	
		p{
			margin: 0px;

			@media only screen and (max-width: 959px) {
	            left: 0px;
	            width: 100%;
	            text-align: center;
	        }

			a{
				img{
				    height: 55px;
				    padding: 16px 0px 6px;
				}			
			}			
		}

	}

	.wooter_links{
		position: absolute;
		right: 15px;

		@media only screen and (max-width: 959px) {
            display: none!important;
        }
		
		ul{
			margin: 0px;
			padding: 0px;	

			.active{
				border-bottom: 4px solid #ef5250;
			}

			.separator{
			    width: 3px;
			    height: 32px;
			    background: rgba(255,255,255,.6);
			    position: absolute;
			    top: 16px;
			    right: 220px;
			}

			li{
				display: inline-block;
				color: rgba(255, 255, 255, .6);
				text-align: center;
				padding: 23px 15px 9px;
				font-size: 14px;
				font-weight: 700;
				-webkit-user-select: none;  
				-moz-user-select: none;     
				-ms-user-select: none;     
				user-select: none;       

				a{
					text-decoration: none;
					color: rgba(255, 255, 255, .6);
				}

				i{
					font-size: 16px;
				}

				a:hover{
					text-decoration: none;					
					color: rgba(255, 255, 255, 1);
				}

				.signup_button{
					background: #ef5350;
					padding: 10px 15px;
					color: white;
					border-radius: 5px;
				}

				.signup_button:hover{
					color: white;
				}

				.d_search{
				    height: 74px;
				    width: 280px!important;
				    background: #454545!important;					
				}

				.active_top{
					border-top: 4px solid #ef5250;
					top: 60px!important;
				}

				.d_athletes{
				    height: 150px;					
				}

				.d_orgs{
				}

				.d_company{
				}

				.dropdown_list{
				    background: #454545;
				    position: absolute;
				    top: 64px;
				    left: 0;
				    width: 170px;
				    padding: 10px 0px 15px;

					ul{
						margin: 0px;
						padding: 0px;
						li{
							padding: 10px 0px 10px 15px;
							margin: 0px;
							
							display: block;
							text-align: left;
							a{
								color: rgba(255,255,255,.6);
							}
							a:hover{
								color: white;
							}
						}
						li:hover{
							background: #3d3d3d
						}
					}
				}
			}
		}
	}
}

.wooter_mobile {
	position: absolute;
	top: 64px;
	left: -280px;
	width: 280px;
	background: #454545;
	box-shadow: 0px 1px 1px 0px #303030;
	z-index: 999;

	.wooter_links{
		ul{
			width: 100%;
			padding: 10px 0px 10px;
			margin: 0px;	

			li{
				display: block;
				color: rgba(255, 255, 255, .6);
				text-align: left;
				padding: 15px 15px;
				font-size: 14px;
				font-weight: 700;

				a{
					text-decoration: none;
					color: rgba(255, 255, 255, .6);
				}

				a:hover{
					text-decoration: none;					
					color: rgba(255, 255, 255, 1);
				}
			}

			li:hover{
				background: #3d3d3d;
			}

			.mobile_search:hover,
			.mobile_sign:hover{
				background: transparent!important;
			}

			.mobile_sign{
				padding-top: 10px;
				a{
					width: 85%;
					float: left;
					text-align: center;
					padding: 10px 15px;
					border-radius: 5px;
				}

				a:hover{
					color: white;
				}

				.signup_button{
					background: #ef5350;
					color: white!important;
				}

				.signup_button:hover{
					color: white;
				}
			}
		}
	}

	.wooter_links{
		min-height: 200px;

		ul{
			padding: 10px 0px 10px;

			li{
				padding-left: 44px;

				a{

					i{
						padding-right: 15px;
						margin-left: -30px;
					}
				}
			}
		}
	}
}

.search_icon{
	position: absolute;
    font-size: 20px;
    top: 15px;
	left:15px;
    z-index: 1100;
    color: rgba(255,255,255,.6);
}

.search_bar{
	position: absolute;
	width: 250px;
	left:15px;
	top: 12px;
	z-index: 1100;

	md-autocomplete{
		background: transparent!important;

		md-autocomplete-wrap{
			box-shadow: none!important;
			border-bottom: 3px solid rgba(255,255,255,.6);

			input{
				color: rgba(255,255,255,.6)!important;
				padding-left: 25px; 
			}
		}
		
		md-autocomplete-wrap:focus{
			border-bottom: 3px solid white;
		}

		md-autocomplete-wrap:hover{
			border-bottom: 3px solid white;
		}
	}

}

.md-virtual-repeat-container.md-autocomplete-suggestions-container{
	z-index: 1100!important;
}



//ANIMATIONS

@-webkit-keyframes mobile_dropdown {
  0%   { left: -280px; }
  100% { left: 0px; }
}
@-moz-keyframes mobile_dropdown {
  0%   { left: -280px; }
  100% { left: 0px; }
}
@-o-keyframes mobile_dropdown {
  0%   { left: -280px; }
  100% { left: 0px; }
}
@keyframes mobile_dropdown {
  0%   { left: -280px; }
  100% { left: 0px; }
}

.dropdown {
  -webkit-animation: mobile_dropdown .5s; 
  -moz-animation:    mobile_dropdown .5s; 
  -o-animation:      mobile_dropdown .5s; 
  animation:         mobile_dropdown .5s; 
  -webkit-animation-fill-mode: forwards;
  -moz-animation-fill-mode:    forwards; 
  -o-animation-fill-mode:      forwards; 
  animation-fill-mode:         forwards; 
}

@-webkit-keyframes mobile_dropup {
  0%   { left: 0px; }
  100% { left: -280px; }
}
@-moz-keyframes mobile_dropup {
  0%   { left: 0px; }
  100% { left: -280px; }
}
@-o-keyframes mobile_dropup {
  0%   { left: 0px; }
  100% { left: -280px; }
}
@keyframes mobile_dropup {
  0%   { left: 0px; }
  100% { left: -280px; }
}

.dropup {
  -webkit-animation: mobile_dropup .5s; 
  -moz-animation:    mobile_dropup .5s;
  -o-animation:      mobile_dropup .5s; 
  animation:         mobile_dropup .5s; 
  -webkit-animation-fill-mode: forwards;
  -moz-animation-fill-mode:    forwards; 
  -o-animation-fill-mode:      forwards; 
  animation-fill-mode:         forwards; 
} -->