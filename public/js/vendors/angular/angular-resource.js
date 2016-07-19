!function(e,r,t){"use strict";function n(e){return null!=e&&""!==e&&"hasOwnProperty"!==e&&s.test("."+e)}function a(e,a){if(!n(a))throw i("badmember",'Dotted member path "@{0}" is invalid.',a);for(var o=a.split("."),s=0,c=o.length;c>s&&r.isDefined(e);s++){var u=o[s];e=null!==e?e[u]:t}return e}function o(e,t){t=t||{},r.forEach(t,function(e,r){delete t[r]});for(var n in e)!e.hasOwnProperty(n)||"$"===n.charAt(0)&&"$"===n.charAt(1)||(t[n]=e[n]);return t}var i=r.$$minErr("$resource"),s=/^(\.[a-zA-Z_$@][0-9a-zA-Z_$@]*)+$/;r.module("resource",["ng"]).provider("$resource",function(){var e=/^https?:\/\/[^\/]*/,n=this;this.defaults={stripTrailingSlashes:!0,actions:{get:{method:"GET"},save:{method:"POST"},query:{method:"GET",isArray:!0},remove:{method:"DELETE"},"delete":{method:"DELETE"}}},this.$get=["$http","$q",function(s,c){function u(e){return p(e,!0).replace(/%26/gi,"&").replace(/%3D/gi,"=").replace(/%2B/gi,"+")}function p(e,r){return encodeURIComponent(e).replace(/%40/gi,"@").replace(/%3A/gi,":").replace(/%24/g,"$").replace(/%2C/gi,",").replace(/%20/g,r?"%20":"+")}function l(e,r){this.template=e,this.defaults=m({},n.defaults,r),this.urlParams={}}function f(e,u,p,v){function w(e,r){var t={};return r=m({},u,r),d(r,function(r,n){$(r)&&(r=r()),t[n]=r&&r.charAt&&"@"==r.charAt(0)?a(e,r.substr(1)):r}),t}function y(e){return e.resource}function E(e){o(e||{},this)}var A=new l(e,v);return p=m({},n.defaults.actions,p),E.prototype.toJSON=function(){var e=m({},this);return delete e.$promise,delete e.$resolved,e},d(p,function(e,n){var a=/^(POST|PUT|PATCH)$/i.test(e.method);E[n]=function(u,p,l,f){var v,b,P,T={};switch(arguments.length){case 4:P=f,b=l;case 3:case 2:if(!$(p)){T=u,v=p,b=l;break}if($(u)){b=u,P=p;break}b=p,P=l;case 1:$(u)?b=u:a?v=u:T=u;break;case 0:break;default:throw i("badargs","Expected up to 4 arguments [params, data, success, error], got {0} arguments",arguments.length)}var O=this instanceof E,x=O?v:e.isArray?[]:new E(v),R={},D=e.interceptor&&e.interceptor.response||y,S=e.interceptor&&e.interceptor.responseError||t;d(e,function(e,r){"params"!=r&&"isArray"!=r&&"interceptor"!=r&&(R[r]=g(e))}),a&&(R.data=v),A.setUrlParams(R,m({},w(v,e.params||{}),T),e.url);var j=s(R).then(function(t){var a=t.data,s=x.$promise;if(a){if(r.isArray(a)!==!!e.isArray)throw i("badcfg","Error in resource configuration for action `{0}`. Expected response to contain an {1} but got an {2} (Request: {3} {4})",n,e.isArray?"array":"object",r.isArray(a)?"array":"object",R.method,R.url);e.isArray?(x.length=0,d(a,function(e){x.push("object"==typeof e?new E(e):e)})):(o(a,x),x.$promise=s)}return x.$resolved=!0,t.resource=x,t},function(e){return x.$resolved=!0,(P||h)(e),c.reject(e)});return j=j.then(function(e){var r=D(e);return(b||h)(r,e.headers),r},S),O?j:(x.$promise=j,x.$resolved=!1,x)},E.prototype["$"+n]=function(e,r,t){$(e)&&(t=r,r=e,e={});var a=E[n].call(this,e,this,r,t);return a.$promise||a}}),E.bind=function(r){return f(e,m({},u,r),p)},E}var h=r.noop,d=r.forEach,m=r.extend,g=r.copy,$=r.isFunction;return l.prototype={setUrlParams:function(t,n,a){var o,s,c=this,p=a||c.template,l="",f=c.urlParams={};d(p.split(/\W/),function(e){if("hasOwnProperty"===e)throw i("badname","hasOwnProperty is not a valid parameter name.");!new RegExp("^\\d+$").test(e)&&e&&new RegExp("(^|[^\\\\]):"+e+"(\\W|$)").test(p)&&(f[e]=!0)}),p=p.replace(/\\:/g,":"),p=p.replace(e,function(e){return l=e,""}),n=n||{},d(c.urlParams,function(e,t){o=n.hasOwnProperty(t)?n[t]:c.defaults[t],r.isDefined(o)&&null!==o?(s=u(o),p=p.replace(new RegExp(":"+t+"(\\W|$)","g"),function(e,r){return s+r})):p=p.replace(new RegExp("(/?):"+t+"(\\W|$)","g"),function(e,r,t){return"/"==t.charAt(0)?t:r+t})}),c.defaults.stripTrailingSlashes&&(p=p.replace(/\/+$/,"")||"/"),p=p.replace(/\/\.(?=\w+($|\?))/,"."),t.url=l+p.replace(/\/\\\./,"/."),d(n,function(e,r){c.urlParams[r]||(t.params=t.params||{},t.params[r]=e)})}},f}]})}(window,window.angular);