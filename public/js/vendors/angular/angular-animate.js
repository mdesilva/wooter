!function(t,e,n){"use strict";function r(t,e,n){if(!t)throw ngMinErr("areq","Argument '{0}' is {1}",e||"?",n||"required");return t}function i(t,e){return t||e?t?e?(K(t)&&(t=t.join(" ")),K(e)&&(e=e.join(" ")),t+" "+e):t:e:""}function o(t){var e={};return t&&(t.to||t.from)&&(e.to=t.to,e.from=t.from),e}function a(t,e,n){var r="";return t=K(t)?t:t&&z(t)&&t.length?t.split(/\s+/):[],L(t,function(t,i){t&&t.length>0&&(r+=i>0?" ":"",r+=n?e+t:t+e)}),r}function s(t,e){var n=t.indexOf(e);e>=0&&t.splice(n,1)}function u(t){if(t instanceof H)switch(t.length){case 0:return[];case 1:if(t[0].nodeType===V)return t;break;default:return H(c(t))}return t.nodeType===V?H(t):void 0}function c(t){if(!t[0])return t;for(var e=0;e<t.length;e++){var n=t[e];if(n.nodeType==V)return n}}function l(t,e,n){L(e,function(e){t.addClass(e,n)})}function h(t,e,n){L(e,function(e){t.removeClass(e,n)})}function f(t){return function(e,n){n.addClass&&(l(t,e,n.addClass),n.addClass=null),n.removeClass&&(h(t,e,n.removeClass),n.removeClass=null)}}function d(t){if(t=t||{},!t.$$prepared){var e=t.domOperation||q;t.domOperation=function(){t.$$domOperationFired=!0,e(),e=q},t.$$prepared=!0}return t}function p(t,e){g(t,e),m(t,e)}function g(t,e){e.from&&(t.css(e.from),e.from=null)}function m(t,e){e.to&&(t.css(e.to),e.to=null)}function v(t,e,n){var r=(e.addClass||"")+" "+(n.addClass||""),i=(e.removeClass||"")+" "+(n.removeClass||""),o=$(t.attr("class"),r,i);n.preparationClasses&&(e.preparationClasses=D(n.preparationClasses,e.preparationClasses),delete n.preparationClasses);var a=e.domOperation!==q?e.domOperation:null;return N(e,n),a&&(e.domOperation=a),o.addClass?e.addClass=o.addClass:e.addClass=null,o.removeClass?e.removeClass=o.removeClass:e.removeClass=null,e}function $(t,e,n){function r(t){z(t)&&(t=t.split(" "));var e={};return L(t,function(t){t.length&&(e[t]=!0)}),e}var i=1,o=-1,a={};t=r(t),e=r(e),L(e,function(t,e){a[e]=i}),n=r(n),L(n,function(t,e){a[e]=a[e]===i?null:o});var s={addClass:"",removeClass:""};return L(a,function(e,n){var r,a;e===i?(r="addClass",a=!t[n]):e===o&&(r="removeClass",a=t[n]),a&&(s[r].length&&(s[r]+=" "),s[r]+=n)}),s}function x(t){return t instanceof e.element?t[0]:t}function y(t,e,n){var r="";e&&(r=a(e,Q,!0)),n.addClass&&(r=D(r,a(n.addClass,X))),n.removeClass&&(r=D(r,a(n.removeClass,G))),r.length&&(n.preparationClasses=r,t.addClass(r))}function w(t,e){e.preparationClasses&&(t.removeClass(e.preparationClasses),e.preparationClasses=null),e.activeClasses&&(t.removeClass(e.activeClasses),e.activeClasses=null)}function b(t,e){var n=e?"-"+e+"s":"";return k(t,[ft,n]),[ft,n]}function C(t,e){var n=e?"paused":"",r=j+ut;return k(t,[r,n]),[r,n]}function k(t,e){var n=e[0],r=e[1];t.style[n]=r}function D(t,e){return t?e?t+" "+e:t:e}function S(){this.$get=["$document",function(t){return H(t[0].body)}]}function E(t){return[ht,t+"s"]}function T(t,e){var n=e?lt:ft;return[n,t+"s"]}function F(t,e,n){var r=Object.create(null),i=t.getComputedStyle(e)||{};return L(n,function(t,e){var n=i[t];if(n){var o=n.charAt(0);("-"===o||"+"===o||o>=0)&&(n=A(n)),0===n&&(n=null),r[e]=n}}),r}function A(t){var e=0,n=t.split(/\s*,\s*/);return L(n,function(t){"s"==t.charAt(t.length-1)&&(t=t.substring(0,t.length-1)),t=parseFloat(t)||0,e=e?Math.max(t,e):t}),e}function P(t){return 0===t||null!=t}function O(t,e){var n=I,r=t+"s";return e?n+=rt:r+=" linear all",[n,r]}function M(){var t=Object.create(null);return{flush:function(){t=Object.create(null)},count:function(e){var n=t[e];return n?n.total:0},get:function(e){var n=t[e];return n&&n.value},put:function(e,n){t[e]?t[e].total++:t[e]={total:1,value:n}}}}var I,R,j,U,q=e.noop,N=e.extend,H=e.element,L=e.forEach,K=e.isArray,z=e.isString,W=e.isObject,_=e.isUndefined,B=e.isDefined,Y=e.isFunction,J=e.isElement,V=1,X="-add",G="-remove",Q="ng-",Z="-active",tt="ng-animate",et="$$ngAnimateChildren",nt="";_(t.ontransitionend)&&B(t.onwebkittransitionend)?(nt="-webkit-",I="WebkitTransition",R="webkitTransitionEnd transitionend"):(I="transition",R="transitionend"),_(t.onanimationend)&&B(t.onwebkitanimationend)?(nt="-webkit-",j="WebkitAnimation",U="webkitAnimationEnd animationend"):(j="animation",U="animationend");var rt="Duration",it="Property",ot="Delay",at="TimingFunction",st="IterationCount",ut="PlayState",ct=9999,lt=j+ot,ht=j+rt,ft=I+ot,dt=I+rt,pt=["$$rAF",function(t){function e(t){r=r.concat(t),n()}function n(){if(r.length){for(var e=r.shift(),o=0;o<e.length;o++)e[o]();i||t(function(){i||n()})}}var r,i;return r=e.queue=[],e.waitUntilQuiet=function(e){i&&i(),i=t(function(){i=null,e(),n()})},e}],gt=[function(){return function(t,n,r){var i=r.ngAnimateChildren;e.isString(i)&&0===i.length?n.data(et,!0):r.$observe("ngAnimateChildren",function(t){t="on"===t||"true"===t,n.data(et,t)})}}],mt="$$animateCss",vt=1e3,$t=3,xt=1.5,yt={transitionDuration:dt,transitionDelay:ft,transitionProperty:I+it,animationDuration:ht,animationDelay:lt,animationIterationCount:j+st},wt={transitionDuration:dt,transitionDelay:ft,animationDuration:ht,animationDelay:lt},bt=["$animateProvider",function(t){var e=M(),n=M();this.$get=["$window","$$jqLite","$$AnimateRunner","$timeout","$$forceReflow","$sniffer","$$rAFScheduler","$animate",function(t,r,i,u,c,l,h,v){function $(t,e){var n="$$ngAnimateParentKey",r=t.parentNode,i=r[n]||(r[n]=++M);return i+"-"+t.getAttribute("class")+"-"+e}function y(n,r,i,o){var a=e.get(i);return a||(a=F(t,n,o),"infinite"===a.animationIterationCount&&(a.animationIterationCount=1)),e.put(i,a),a}function w(i,o,s,u){var c;if(e.count(s)>0&&(c=n.get(s),!c)){var l=a(o,"-stagger");r.addClass(i,l),c=F(t,i,u),c.animationDuration=Math.max(c.animationDuration,0),c.transitionDuration=Math.max(c.transitionDuration,0),r.removeClass(i,l),n.put(s,c)}return c||{}}function D(t){N.push(t),h.waitUntilQuiet(function(){e.flush(),n.flush();for(var t=c(),r=0;r<N.length;r++)N[r](t);N.length=0})}function S(t,e,n){var r=y(t,e,n,yt),i=r.animationDelay,o=r.transitionDelay;return r.maxDelay=i&&o?Math.max(i,o):i||o,r.maxDuration=Math.max(r.animationDuration*r.animationIterationCount,r.transitionDuration),r}var A=f(r),M=0,N=[];return function(t,n){function c(){f()}function h(){f(!0)}function f(e){H||W&&z||(H=!0,z=!1,n.$$skipPreparationClasses||r.removeClass(t,ht),r.removeClass(t,dt),C(N,!1),b(N,!1),L(et,function(t){N.style[t[0]]=""}),A(t,n),p(t,n),n.onDone&&n.onDone(),_&&_.complete(!e))}function y(t){Ot.blockTransition&&b(N,t),Ot.blockKeyframeAnimation&&C(N,!!t)}function F(){return _=new i({end:c,cancel:h}),D(q),f(),{$$willAnimate:!1,start:function(){return _},end:c}}function M(){function e(){if(!H){if(y(!1),L(et,function(t){var e=t[0],n=t[1];N.style[e]=n}),A(t,n),r.addClass(t,dt),Ot.recalculateTimingStyles){if(ft=N.className+" "+ht,yt=$(N,ft),At=S(N,ft,yt),Pt=At.maxDelay,Y=Math.max(Pt,0),V=At.maxDuration,0===V)return void f();Ot.hasTransitions=At.transitionDuration>0,Ot.hasAnimations=At.animationDuration>0}if(Ot.applyAnimationDelay&&(Pt="boolean"!=typeof n.delay&&P(n.delay)?parseFloat(n.delay):Pt,Y=Math.max(Pt,0),At.animationDelay=Pt,Mt=T(Pt,!0),et.push(Mt),N.style[Mt[0]]=Mt[1]),J=Y*vt,tt=V*vt,n.easing){var e,s=n.easing;Ot.hasTransitions&&(e=I+at,et.push([e,s]),N.style[e]=s),Ot.hasAnimations&&(e=j+at,et.push([e,s]),N.style[e]=s)}At.transitionDuration&&c.push(R),At.animationDuration&&c.push(U),a=Date.now();var l=J+xt*tt,h=a+l,d=t.data(mt)||[],p=!0;if(d.length){var g=d[0];p=h>g.expectedEndTime,p?u.cancel(g.timer):d.push(f)}if(p){var v=u(i,l,!1);d[0]={timer:v,expectedEndTime:h},d.push(f),t.data(mt,d)}t.on(c.join(" "),o),m(t,n)}}function i(){var e=t.data(mt);if(e){for(var n=1;n<e.length;n++)e[n]();t.removeData(mt)}}function o(t){t.stopPropagation();var e=t.originalEvent||t,n=e.$manualTimeStamp||e.timeStamp||Date.now(),r=parseFloat(e.elapsedTime.toFixed($t));Math.max(n-a,0)>=J&&r>=V&&(W=!0,f())}if(!H){if(!N.parentNode)return void f();var a,c=[],l=function(t){if(W)z&&t&&(z=!1,f());else if(z=!t,At.animationDuration){var e=C(N,z);z?et.push(e):s(et,e)}},h=Tt>0&&(At.transitionDuration&&0===bt.transitionDuration||At.animationDuration&&0===bt.animationDuration)&&Math.max(bt.animationDelay,bt.transitionDelay);h?u(e,Math.floor(h*Tt*vt),!1):e(),B.resume=function(){l(!0)},B.pause=function(){l(!1)}}}var N=x(t);if(!N||!N.parentNode||!v.enabled())return F();n=d(n);var H,z,W,_,B,Y,J,V,tt,et=[],nt=t.attr("class"),rt=o(n);if(0===n.duration||!l.animations&&!l.transitions)return F();var ot=n.event&&K(n.event)?n.event.join(" "):n.event,st=ot&&n.structural,ut="",lt="";st?ut=a(ot,Q,!0):ot&&(ut=ot),n.addClass&&(lt+=a(n.addClass,X)),n.removeClass&&(lt.length&&(lt+=" "),lt+=a(n.removeClass,G)),n.applyClassesEarly&&lt.length&&A(t,n);var ht=[ut,lt].join(" ").trim(),ft=nt+" "+ht,dt=a(ht,Z),pt=rt.to&&Object.keys(rt.to).length>0,gt=(n.keyframeStyle||"").length>0;if(!gt&&!pt&&!ht)return F();var yt,bt;if(n.stagger>0){var Ct=parseFloat(n.stagger);bt={transitionDelay:Ct,animationDelay:Ct,transitionDuration:0,animationDuration:0}}else yt=$(N,ft),bt=w(N,ht,yt,wt);n.$$skipPreparationClasses||r.addClass(t,ht);var kt;if(n.transitionStyle){var Dt=[I,n.transitionStyle];k(N,Dt),et.push(Dt)}if(n.duration>=0){kt=N.style[I].length>0;var St=O(n.duration,kt);k(N,St),et.push(St)}if(n.keyframeStyle){var Et=[j,n.keyframeStyle];k(N,Et),et.push(Et)}var Tt=bt?n.staggerIndex>=0?n.staggerIndex:e.count(yt):0,Ft=0===Tt;Ft&&!n.skipBlocking&&b(N,ct);var At=S(N,ft,yt),Pt=At.maxDelay;Y=Math.max(Pt,0),V=At.maxDuration;var Ot={};if(Ot.hasTransitions=At.transitionDuration>0,Ot.hasAnimations=At.animationDuration>0,Ot.hasTransitionAll=Ot.hasTransitions&&"all"==At.transitionProperty,Ot.applyTransitionDuration=pt&&(Ot.hasTransitions&&!Ot.hasTransitionAll||Ot.hasAnimations&&!Ot.hasTransitions),Ot.applyAnimationDuration=n.duration&&Ot.hasAnimations,Ot.applyTransitionDelay=P(n.delay)&&(Ot.applyTransitionDuration||Ot.hasTransitions),Ot.applyAnimationDelay=P(n.delay)&&Ot.hasAnimations,Ot.recalculateTimingStyles=lt.length>0,(Ot.applyTransitionDuration||Ot.applyAnimationDuration)&&(V=n.duration?parseFloat(n.duration):V,Ot.applyTransitionDuration&&(Ot.hasTransitions=!0,At.transitionDuration=V,kt=N.style[I+it].length>0,et.push(O(V,kt))),Ot.applyAnimationDuration&&(Ot.hasAnimations=!0,At.animationDuration=V,et.push(E(V)))),0===V&&!Ot.recalculateTimingStyles)return F();if(null!=n.delay){var Mt=parseFloat(n.delay);Ot.applyTransitionDelay&&et.push(T(Mt)),Ot.applyAnimationDelay&&et.push(T(Mt,!0))}return null==n.duration&&At.transitionDuration>0&&(Ot.recalculateTimingStyles=Ot.recalculateTimingStyles||Ft),J=Y*vt,tt=V*vt,n.skipBlocking||(Ot.blockTransition=At.transitionDuration>0,Ot.blockKeyframeAnimation=At.animationDuration>0&&bt.animationDelay>0&&0===bt.animationDuration),g(t,n),Ot.blockTransition||Ot.blockKeyframeAnimation?y(V):n.skipBlocking||b(N,!1),{$$willAnimate:!0,end:c,start:function(){return H?void 0:(B={end:c,cancel:h,resume:null,pause:null},_=new i(B),D(M),_)}}}}]}],Ct=["$$animationProvider",function(t){t.drivers.push("$$animateCssDriver");var e="ng-animate-shim",n="ng-anchor",r="ng-anchor-out",i="ng-anchor-in";this.$get=["$animateCss","$rootScope","$$AnimateRunner","$rootElement","$$body","$sniffer","$$jqLite",function(t,o,a,s,u,c,l){function h(t){return t.replace(/\bng-\S+\b/g,"")}function d(t,e){return z(t)&&(t=t.split(" ")),z(e)&&(e=e.split(" ")),t.filter(function(t){return-1===e.indexOf(t)}).join(" ")}function p(o,s,u){function c(t){var e={},n=x(t).getBoundingClientRect();return L(["width","height","top","left"],function(t){var r=n[t];switch(t){case"top":r+=v.scrollTop;break;case"left":r+=v.scrollLeft}e[t]=Math.floor(r)+"px"}),e}function l(){var e=t(m,{addClass:r,delay:!0,from:c(s)});return e.$$willAnimate?e:null}function f(t){return t.attr("class")||""}function p(){var e=h(f(u)),n=d(e,$),o=d($,e),a=t(m,{to:c(u),addClass:i+" "+n,removeClass:r+" "+o,delay:!0});return a.$$willAnimate?a:null}function g(){m.remove(),s.removeClass(e),u.removeClass(e)}var m=H(x(s).cloneNode(!0)),$=h(f(m));s.addClass(e),u.addClass(e),m.addClass(n),y.append(m);var w,b=l();if(!b&&(w=p(),!w))return g();var C=b||w;return{start:function(){function t(){n&&n.end()}var e,n=C.start();return n.done(function(){return n=null,!w&&(w=p())?(n=w.start(),n.done(function(){n=null,g(),e.complete()}),n):(g(),void e.complete())}),e=new a({end:t,cancel:t})}}}function g(t,e,n,r){var i=m(t,q),o=m(e,q),s=[];return L(r,function(t){var e=t.out,r=t["in"],i=p(n,e,r);i&&s.push(i)}),i||o||0!==s.length?{start:function(){function t(){L(e,function(t){t.end()})}var e=[];i&&e.push(i.start()),o&&e.push(o.start()),L(s,function(t){e.push(t.start())});var n=new a({end:t,cancel:t});return a.all(e,function(t){n.complete(t)}),n}}:void 0}function m(e){var n=e.element,r=e.options||{};e.structural&&(r.event=e.event,r.structural=!0,r.applyClassesEarly=!0,"leave"===e.event&&(r.onDone=r.domOperation)),r.preparationClasses&&(r.event=D(r.event,r.preparationClasses));var i=t(n,r);return i.$$willAnimate?i:null}if(!c.animations&&!c.transitions)return q;var v=x(u),$=x(s),y=H(v.parentNode===$?v:$);f(l);return function(t){return t.from&&t.to?g(t.from,t.to,t.classes,t.anchors):m(t)}}]}],kt=["$animateProvider",function(t){this.$get=["$injector","$$AnimateRunner","$$jqLite",function(e,n,r){function i(n){n=K(n)?n:n.split(" ");for(var r=[],i={},o=0;o<n.length;o++){var a=n[o],s=t.$$registeredAnimations[a];s&&!i[a]&&(r.push(e.get(s)),i[a]=!0)}return r}var o=f(r);return function(t,e,r,a){function s(){a.domOperation(),o(t,a)}function u(t,e,r,i,o){var a;switch(r){case"animate":a=[e,i.from,i.to,o];break;case"setClass":a=[e,g,m,o];break;case"addClass":a=[e,g,o];break;case"removeClass":a=[e,m,o];break;default:a=[e,o]}a.push(i);var s=t.apply(t,a);if(s)if(Y(s.start)&&(s=s.start()),s instanceof n)s.done(o);else if(Y(s))return s;return q}function c(t,e,r,i,o){var a=[];return L(i,function(i){var s=i[o];s&&a.push(function(){var i,o,a=!1,c=function(t){a||(a=!0,(o||q)(t),i.complete(!t))};return i=new n({end:function(){c()},cancel:function(){c(!0)}}),o=u(s,t,e,r,function(t){var e=t===!1;c(e)}),i})}),a}function l(t,e,r,i,o){var a=c(t,e,r,i,o);if(0===a.length){var s,u;"beforeSetClass"===o?(s=c(t,"removeClass",r,i,"beforeRemoveClass"),u=c(t,"addClass",r,i,"beforeAddClass")):"setClass"===o&&(s=c(t,"removeClass",r,i,"removeClass"),u=c(t,"addClass",r,i,"addClass")),s&&(a=a.concat(s)),u&&(a=a.concat(u))}if(0!==a.length)return function(t){var e=[];return a.length&&L(a,function(t){e.push(t())}),e.length?n.all(e,t):t(),function(t){L(e,function(e){t?e.cancel():e.end()})}}}3===arguments.length&&W(r)&&(a=r,r=null),a=d(a),r||(r=t.attr("class")||"",a.addClass&&(r+=" "+a.addClass),a.removeClass&&(r+=" "+a.removeClass));var h,f,g=a.addClass,m=a.removeClass,v=i(r);if(v.length){var $,x;"leave"==e?(x="leave",$="afterLeave"):(x="before"+e.charAt(0).toUpperCase()+e.substr(1),$=e),"enter"!==e&&"move"!==e&&(h=l(t,e,a,v,x)),f=l(t,e,a,v,$)}return h||f?{start:function(){function e(e){u=!0,s(),p(t,a),c.complete(e)}function r(t){u||((i||q)(t),e(t))}var i,o=[];h&&o.push(function(t){i=h(t)}),o.length?o.push(function(t){s(),t(!0)}):s(),f&&o.push(function(t){i=f(t)});var u=!1,c=new n({end:function(){r()},cancel:function(){r(!0)}});return n.chain(o,e),c}}:void 0}}]}],Dt=["$$animationProvider",function(t){t.drivers.push("$$animateJsDriver"),this.$get=["$$animateJs","$$AnimateRunner",function(t,e){function n(e){var n=e.element,r=e.event,i=e.options,o=e.classes;return t(n,r,o,i)}return function(t){if(t.from&&t.to){var r=n(t.from),i=n(t.to);if(!r&&!i)return;return{start:function(){function t(){return function(){L(o,function(t){t.end()})}}function n(t){a.complete(t)}var o=[];r&&o.push(r.start()),i&&o.push(i.start()),e.all(o,n);var a=new e({end:t(),cancel:t()});return a}}}return n(t)}}]}],St="data-ng-animate",Et="$ngAnimatePin",Tt=["$animateProvider",function(t){function e(t,e,n,r){return a[t].some(function(t){return t(e,n,r)})}function n(t,e){t=t||{};var n=(t.addClass||"").length>0,r=(t.removeClass||"").length>0;return e?n&&r:n||r}var i=1,o=2,a=this.rules={skip:[],cancel:[],join:[]};a.join.push(function(t,e,r){return!e.structural&&n(e.options)}),a.skip.push(function(t,e,r){return!e.structural&&!n(e.options)}),a.skip.push(function(t,e,n){return"leave"==n.event&&e.structural}),a.skip.push(function(t,e,n){return n.structural&&n.state===o&&!e.structural}),a.cancel.push(function(t,e,n){return n.structural&&e.structural}),a.cancel.push(function(t,e,n){return n.state===o&&e.structural}),a.cancel.push(function(t,e,n){var r=e.options,i=n.options;return r.addClass&&r.addClass===i.removeClass||r.removeClass&&r.removeClass===i.addClass}),this.$get=["$$rAF","$rootScope","$rootElement","$document","$$body","$$HashMap","$$animation","$$AnimateRunner","$templateRequest","$$jqLite","$$forceReflow",function(a,s,l,h,g,m,$,b,C,k,D){function S(t,e){return v(t,e,{})}function E(t,e){var n=x(t),r=[],i=H[e];return i&&L(i,function(t){t.node.contains(n)&&r.push(t.callback)}),r}function T(t,e,n,r){a(function(){L(E(e,t),function(t){t(e,n,r)})})}function F(t,r,a){function c(e,n,r,i){T(n,t,r,i),e.progress(n,r,i)}function l(e){w(t,a),G(t,a),p(t,a),a.domOperation(),g.complete(!e)}var h,f;t=u(t),t&&(h=x(t),f=t.parent()),a=d(a);var g=new b;if(K(a.addClass)&&(a.addClass=a.addClass.join(" ")),a.addClass&&!z(a.addClass)&&(a.addClass=null),K(a.removeClass)&&(a.removeClass=a.removeClass.join(" ")),a.removeClass&&!z(a.removeClass)&&(a.removeClass=null),a.from&&!W(a.from)&&(a.from=null),a.to&&!W(a.to)&&(a.to=null),!h)return l(),g;var m=[h.className,a.addClass,a.removeClass].join(" ");if(!X(m))return l(),g;var C=["enter","move","leave"].indexOf(r)>=0,k=!U||j.get(h),D=!k&&R.get(h)||{},E=!!D.state;if(k||E&&D.state==i||(k=!M(t,f,r)),k)return l(),g;C&&A(t);var F={structural:C,element:t,event:r,close:l,options:a,runner:g};if(E){var O=e("skip",t,F,D);if(O)return D.state===o?(l(),g):(v(t,D.options,a),D.runner);var q=e("cancel",t,F,D);if(q)if(D.state===o)D.runner.end();else{if(!D.structural)return v(t,D.options,F.options),D.runner;D.close()}else{var N=e("join",t,F,D);if(N){if(D.state!==o)return y(t,C?r:null,a),r=F.event=D.event,a=v(t,D.options,F.options),D.runner;S(t,a)}}}else S(t,a);var H=F.structural;if(H||(H="animate"===F.event&&Object.keys(F.options.to||{}).length>0||n(F.options)),!H)return l(),P(t),g;var L=(D.counter||0)+1;return F.counter=L,I(t,i,F),s.$$postDigest(function(){var e=R.get(h),i=!e;e=e||{};var s=t.parent()||[],u=s.length>0&&("animate"===e.event||e.structural||n(e.options));if(i||e.counter!==L||!u)return i&&(G(t,a),p(t,a)),(i||C&&e.event!==r)&&(a.domOperation(),g.end()),void(u||P(t));r=!e.structural&&n(e.options,!0)?"setClass":e.event,I(t,o);var f=$(t,r,e.options);f.done(function(e){l(!e);var n=R.get(h);n&&n.counter===L&&P(x(t)),c(g,r,"close",{})}),g.setHost(f),c(g,r,"start",{})}),g}function A(t){var e=x(t),n=e.querySelectorAll("["+St+"]");L(n,function(t){var e=parseInt(t.getAttribute(St)),n=R.get(t);switch(e){case o:n.runner.end();case i:n&&R.remove(t)}})}function P(t){var e=x(t);e.removeAttribute(St),R.remove(e)}function O(t,e){return x(t)===x(e)}function M(t,e,n){var r,i=O(t,g)||"HTML"===t[0].nodeName,o=O(t,l),a=!1,s=t.data(Et);for(s&&(e=s);e&&e.length;){o||(o=O(e,l));var u=e[0];if(u.nodeType!==V)break;var c=R.get(u)||{};if(a||(a=c.structural||j.get(u)),_(r)||r===!0){var h=e.data(et);B(h)&&(r=h)}if(a&&r===!1)break;o||(o=O(e,l),o||(s=e.data(Et),s&&(e=s))),i||(i=O(e,g)),e=e.parent()}var f=!a||r;return f&&o&&i}function I(t,e,n){n=n||{},n.state=e;var r=x(t);r.setAttribute(St,e);var i=R.get(r),o=i?N(i,n):n;R.put(r,o)}var R=new m,j=new m,U=null,q=s.$watch(function(){return 0===C.totalPendingRequests},function(t){t&&(q(),s.$$postDigest(function(){s.$$postDigest(function(){null===U&&(U=!0)})}))}),H={},Y=t.classNameFilter(),X=Y?function(t){return Y.test(t)}:function(){return!0},G=f(k);return{on:function(t,e,n){var r=c(e);H[t]=H[t]||[],H[t].push({node:r,callback:n})},off:function(t,e,n){function r(t,e,n){var r=c(e);return t.filter(function(t){var e=t.node===r&&(!n||t.callback===n);return!e})}var i=H[t];i&&(H[t]=1===arguments.length?null:r(i,e,n))},pin:function(t,e){r(J(t),"element","not an element"),r(J(e),"parentElement","not an element"),t.data(Et,e)},push:function(t,e,n,r){return n=n||{},n.domOperation=r,F(t,e,n)},enabled:function(t,e){var n=arguments.length;if(0===n)e=!!U;else{var r=J(t);if(r){var i=x(t),o=j.get(i);1===n?e=!o:(e=!!e,e?o&&j.remove(i):j.put(i,!0))}else e=U=!!t}return e}}}]}],Ft=["$$rAF",function(t){function e(e){n.push(e),n.length>1||t(function(){for(var t=0;t<n.length;t++)n[t]();n=[]})}var n=[];return function(){var t=!1;return e(function(){t=!0}),function(n){t?n():e(n)}}}],At=["$q","$sniffer","$$animateAsyncRun",function(t,e,n){function r(t){this.setHost(t),this._doneCallbacks=[],this._runInAnimationFrame=n(),this._state=0}var i=0,o=1,a=2;return r.chain=function(t,e){function n(){return r===t.length?void e(!0):void t[r](function(t){return t===!1?void e(!1):(r++,void n())})}var r=0;n()},r.all=function(t,e){function n(n){i=i&&n,++r===t.length&&e(i)}var r=0,i=!0;L(t,function(t){t.done(n)})},r.prototype={setHost:function(t){this.host=t||{}},done:function(t){this._state===a?t():this._doneCallbacks.push(t)},progress:q,getPromise:function(){if(!this.promise){var e=this;this.promise=t(function(t,n){e.done(function(e){e===!1?n():t()})})}return this.promise},then:function(t,e){return this.getPromise().then(t,e)},"catch":function(t){return this.getPromise()["catch"](t)},"finally":function(t){return this.getPromise()["finally"](t)},pause:function(){this.host.pause&&this.host.pause()},resume:function(){this.host.resume&&this.host.resume()},end:function(){this.host.end&&this.host.end(),this._resolve(!0)},cancel:function(){this.host.cancel&&this.host.cancel(),this._resolve(!1)},complete:function(t){var e=this;e._state===i&&(e._state=o,e._runInAnimationFrame(function(){e._resolve(t)}))},_resolve:function(t){this._state!==a&&(L(this._doneCallbacks,function(e){e(t)}),this._doneCallbacks.length=0,this._state=a)}},r}],Pt=["$animateProvider",function(t){function e(t,e){t.data(s,e)}function n(t){t.removeData(s)}function r(t){return t.data(s)}var o="ng-animate-ref",a=this.drivers=[],s="$$animationRunner";this.$get=["$$jqLite","$rootScope","$injector","$$AnimateRunner","$$HashMap","$$rAFScheduler",function(t,s,u,c,l,h){function g(t){function e(t){if(t.processed)return t;t.processed=!0;var n=t.domNode,r=n.parentNode;o.put(n,t);for(var a;r;){if(a=o.get(r)){a.processed||(a=e(a));break}r=r.parentNode}return(a||i).children.push(t),t}function n(t){var e,n=[],r=[];for(e=0;e<t.children.length;e++)r.push(t.children[e]);var i=r.length,o=0,a=[];for(e=0;e<r.length;e++){var s=r[e];0>=i&&(i=o,o=0,n.push(a),a=[]),a.push(s.fn),s.children.forEach(function(t){o++,r.push(t)}),i--}return a.length&&n.push(a),n}var r,i={children:[]},o=new l;for(r=0;r<t.length;r++){var a=t[r];o.put(a.domNode,t[r]={domNode:a.domNode,fn:a.fn,children:[]})}for(r=0;r<t.length;r++)e(t[r]);return n(i)}var m=[],v=f(t);return function(l,f,$){function y(t){var e="["+o+"]",n=t.hasAttribute(o)?[t]:t.querySelectorAll(e),r=[];return L(n,function(t){var e=t.getAttribute(o);e&&e.length&&r.push(t)}),r}function w(t){var e=[],n={};L(t,function(t,r){var i=t.element,a=x(i),s=t.event,u=["enter","move"].indexOf(s)>=0,c=t.structural?y(a):[];if(c.length){var l=u?"to":"from";L(c,function(t){var e=t.getAttribute(o);n[e]=n[e]||{},n[e][l]={animationID:r,element:H(t)}})}else e.push(t)});var r={},i={};return L(n,function(n,o){var a=n.from,s=n.to;if(!a||!s){var u=a?a.animationID:s.animationID,c=u.toString();return void(r[c]||(r[c]=!0,e.push(t[u])))}var l=t[a.animationID],h=t[s.animationID],f=a.animationID.toString();if(!i[f]){var d=i[f]={structural:!0,beforeStart:function(){l.beforeStart(),h.beforeStart()},close:function(){l.close(),h.close()},classes:b(l.classes,h.classes),from:l,to:h,anchors:[]};d.classes.length?e.push(d):(e.push(l),e.push(h))}i[f].anchors.push({out:a.element,"in":s.element})}),e}function b(t,e){t=t.split(" "),e=e.split(" ");for(var n=[],r=0;r<t.length;r++){var i=t[r];if("ng-"!==i.substring(0,3))for(var o=0;o<e.length;o++)if(i===e[o]){n.push(i);break}}return n.join(" ")}function C(t){for(var e=a.length-1;e>=0;e--){var n=a[e];if(u.has(n)){var r=u.get(n),i=r(t);if(i)return i}}}function k(){l.addClass(tt),P&&t.addClass(l,P)}function D(t,e){function n(t){r(t).setHost(e)}t.from&&t.to?(n(t.from.element),n(t.to.element)):n(t.element)}function S(){var t=r(l);!t||"leave"===f&&$.$$domOperationFired||t.end()}function E(e){l.off("$destroy",S),n(l),v(l,$),p(l,$),$.domOperation(),P&&t.removeClass(l,P),l.removeClass(tt),F.complete(!e)}$=d($);var T=["enter","move","leave"].indexOf(f)>=0,F=new c({end:function(){E()},cancel:function(){E(!0)}});if(!a.length)return E(),F;e(l,F);var A=i(l.attr("class"),i($.addClass,$.removeClass)),P=$.tempClasses;return P&&(A+=" "+P,$.tempClasses=null),m.push({element:l,classes:A,event:f,structural:T,options:$,beforeStart:k,close:E}),l.on("$destroy",S),m.length>1?F:(s.$$postDigest(function(){var t=[];L(m,function(e){r(e.element)?t.push(e):e.close()}),m.length=0;var e=w(t),n=[];L(e,function(t){n.push({domNode:x(t.from?t.from.element:t.element),fn:function(){t.beforeStart();var e,n=t.close,i=t.anchors?t.from.element||t.to.element:t.element;if(r(i)){var o=C(t);o&&(e=o.start)}if(e){var a=e();a.done(function(t){n(!t)}),D(t,a)}else n()}})}),h(g(n))}),F)}}]}];e.module("ngAnimate",[]).provider("$$body",S).directive("ngAnimateChildren",gt).factory("$$rAFScheduler",pt).factory("$$AnimateRunner",At).factory("$$animateAsyncRun",Ft).provider("$$animateQueue",Tt).provider("$$animation",Pt).provider("$animateCss",bt).provider("$$animateCssDriver",Ct).provider("$$animateJs",kt).provider("$$animateJsDriver",Dt)}(window,window.angular);