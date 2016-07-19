<!DOCTYPE html>
<html lang="en" ng-app="appDemo">
    <head>
    <title>Easy form generator</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Erwan Datin (MacKentoch)">
	<link href="/css/vendors/bootstrap/index.css" rel="stylesheet">
	<link href="/fmly/css/bootswatch.paper.bootstrap.min" rel="stylesheet">
	<link href="/css/vendors/font-awesome/index.css" rel="stylesheet">
	<link href="/fmly/css/animate---css.animate.min" rel="stylesheet">
	<link href='/fmly/css/easy-form-generator.dist.css.eda---textAngular.min' rel='stylesheet'>
	<link href='/fmly/css/angularjs-toaster.toaster.min'  rel='stylesheet'>
	<link href='/fmly/css/nya-bootstrap-select.dist.css.nya-bs-select.min' rel='stylesheet'>
	<link href="/fmly/css/easy-form-generator.dist.css.eda---stepway.min" rel="stylesheet">
  <head>
  <body ng-controller="demoController as demoCtrl" ng-cloak>  
			<!-- navigation : just for decoration it is not easy form generator
			=============================================================-->
			<header id="pageHeader" >	
				<div class="navbar navbar-default navbar-fixed-top">
			      <div class="container">
			        <div class="navbar-header">
			          <a class="navbar-brand" href="#">Easy form generator</a>
			          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
			            <span class="icon-bar"></span>
			            <span class="icon-bar"></span>
			            <span class="icon-bar"></span>
			          </button>
			        </div>
			        <div class="navbar-collapse collapse" id="navbar-main">
			          <ul class="nav navbar-nav">
			          </ul>
								<ul class="nav navbar-nav navbar-left">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
											Switch language 
											<span class="caret"></span></a>
										<ul class="dropdown-menu" role="menu">
											<li><a href="#" ng-click="demoCtrl.switchLanguage('en')">English</a></li>
											<li><a href="#" ng-click="demoCtrl.switchLanguage('fr')">French</a></li>
											<li><a href="#" ng-click="demoCtrl.switchLanguage('es')">Spanish</a></li>
											<li><a href="#" ng-click="demoCtrl.switchLanguage('de')">German</a></li>
											<li><a href="#" ng-click="demoCtrl.switchLanguage('jp')">Japanese</a></li>
											<li><a href="#" ng-click="demoCtrl.switchLanguage('tr')">Turkish</a></li>
										</ul>
									</li>									
								</ul>
			          <ul class="nav navbar-nav navbar-right">
			          	<li><a class="socialIcon" target="_blank" href="https://github.com/MacKentoch"><span class="text-center"><i class="fa fa-github"></i></span></a></li>
			          </ul>
			        </div>
			      </div>
			    </div>
			</header>   		
    <!-- Easy form generator: Step Way -->
    <eda-step-way-easy-form-gen 	
          eda-easy-form-generator-model="demoCtrl.easyFormGeneratorModel"
          eda-save-form-event="demoCtrl.saveForm(edaEasyFormGeneratorModel)">
    </eda-step-way-easy-form-gen>
    <!-- at the end of the body : all js -->
    <script type="text/javascript" src="/js/vendors/angular/angular.js"></script>
    <!-- YOUR APPLICATION WILL REPLACE THIS : -->
    <script type="text/javascript">
    (function(angular){
        'use strict';
        angular
            .module('appDemo', ['eda.easyformGen.stepway'])
            .config(configFct)
            .controller('demoController', demoController);
				/**
				 * config
				 */
				configFct.$inject = ['easyFormSteWayConfigProvider'];
				function configFct(easyFormSteWayConfigProvider){
          //example get current language (by default = english)
          console.info('- from config - language is ' + easyFormSteWayConfigProvider.getCurrentLanguage());
          //set language to french :
          //easyFormSteWayConfigProvider.setLanguage('fr');          
					//show/hide preview panel => default is true 
					easyFormSteWayConfigProvider.showPreviewPanel(true);
					//show/hide models in preview panel => default is true
					easyFormSteWayConfigProvider.showPreviewModels(true);
				}
				/**
				 * controller 
				 **/	
				demoController.$inject = ['$timeout', 'easyFormSteWayConfig'];	
				function demoController($timeout, easyFormSteWayConfig){
					var demoCtrl = this;
					demoCtrl.easyFormGeneratorModel	= {}; // TIP : save a form then look at the console to get a better idea of this model
					demoCtrl.saveForm 							= saveForm;
					demoCtrl.currentLangue					= refreshCurrentLanguage();
					demoCtrl.switchLanguage					= switchLanguage;
					//get current language
					console.info('Current language is ' + demoCtrl.currentLangue);
					function switchLanguage(toLanguage){
						if(angular.isString){
							easyFormSteWayConfig.setLanguage(toLanguage);
							refreshCurrentLanguage();
							console.info('language changed to ' + demoCtrl.currentLangue);
						}
					}
					function refreshCurrentLanguage(){
						return easyFormSteWayConfig.getCurrentLanguage();
					}
					/**
					 * when click on save form, will call your save form function :
					 */
					function saveForm(easyFormGeneratorModel){
						console.info('-> from here : you can save models to database (your controller)');							
						console.dir({
								'What is it?' : 'this log shows you easy form returned model on save event',
								'easyFormGeneratorModel' : easyFormGeneratorModel
						});		
         } 
        } 
        /**
          * 
          * MORE DETAILS ON 'easyFormGeneratorModel'
          * ----------------------------------------
          * 
          * easy form generator model properties:
          * 
          * - formName 									  : {string} (at save step you name your form)
          * - btnSubmitText 							: {string} (if 'Submit' does not suits to you change submit button name)
          * - btnCancelText							  : {string} (if 'Cancel' does not suits to you change cancel button name)
          * - edaFieldsModel 						  : {array} - easy form generator model that describe form
          * - edaFieldsModelStringified 	: {string} - exactly same as edaFieldsModel it is just stringified
          * - formlyFieldsModel 					: {object} - easy form generator model translate by itself 'edaFieldsModel' to 'angular formly fields model' -> usefull is you just need a formly directive
          * - dataModel									  : {object} - this object is filled when filling form. 
          */
    })(angular);
    </script>
	<script type="text/javascript" src="/fmly/js/jquery.dist.jquery.min"></script>
	<script type="text/javascript" src="/fmly/js/bootstrap.dist.js.bootstrap.min"></script>
	<script type="text/javascript" src="/fmly/js/angular-bootstrap.ui-bootstrap-tpls.min"></script>
	<script type="text/javascript" src="/fmly/js/easy-form-generator.dist.js.eda---stepway.min"></script>
	<script type="text/javascript" src='/fmly/js/textAngular.dist.textAngular-rangy.min'></script>
	<script type="text/javascript" src='/fmly/js/textAngular.dist.textAngular-sanitize.min'></script>
	<script type="text/javascript" src='/fmly/js/textAngular.dist.textAngular.min'></script>
	<script type="text/javascript" src='/fmly/js/lodash.lodash.min'></script>
	<script type="text/javascript" src="/fmly/js/angular-animate.angular-animate"></script>
	<script type="text/javascript" src="/fmly/js/angular-translate.angular-translate"></script>
	<script type="text/javascript" src="/fmly/js/angularjs-toaster.toaster"></script>
	<script type="text/javascript" src="/fmly/js/nya-bootstrap-select.dist.js.nya-bs-select"></script>
	<script type="text/javascript" src="/fmly/js/api-check.dist.api-check.min"></script>
	<script type="text/javascript" src="/fmly/js/angular-formly.dist.formly.min"></script>
	<script type="text/javascript" src="/fmly/js/angular-formly-templates-bootstrap.dist.angular-formly-templates-bootstrap"></script>
  </body>
</html> 