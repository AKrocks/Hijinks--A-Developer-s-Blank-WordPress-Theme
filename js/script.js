function t(e,o){function i(t,e){return function(){return t.apply(e,arguments)}}var s;if(o=o||{},this.trackingClick=!1,this.trackingClickStart=0,this.targetElement=null,this.touchStartX=0,this.touchStartY=0,this.lastTouchIdentifier=0,this.touchBoundary=o.touchBoundary||10,this.layer=e,this.tapDelay=o.tapDelay||200,this.tapTimeout=o.tapTimeout||700,!t.notNeeded(e)){for(var r=["onMouse","onClick","onTouchStart","onTouchMove","onTouchEnd","onTouchCancel"],a=this,c=0,l=r.length;c<l;c++)a[r[c]]=i(a[r[c]],a);n&&(e.addEventListener("mouseover",this.onMouse,!0),e.addEventListener("mousedown",this.onMouse,!0),e.addEventListener("mouseup",this.onMouse,!0)),e.addEventListener("click",this.onClick,!0),e.addEventListener("touchstart",this.onTouchStart,!1),e.addEventListener("touchmove",this.onTouchMove,!1),e.addEventListener("touchend",this.onTouchEnd,!1),e.addEventListener("touchcancel",this.onTouchCancel,!1),Event.prototype.stopImmediatePropagation||(e.removeEventListener=function(t,n,o){var i=Node.prototype.removeEventListener;"click"===t?i.call(e,t,n.hijacked||n,o):i.call(e,t,n,o)},e.addEventListener=function(t,n,o){var i=Node.prototype.addEventListener;"click"===t?i.call(e,t,n.hijacked||(n.hijacked=function(t){t.propagationStopped||n(t)}),o):i.call(e,t,n,o)}),"function"==typeof e.onclick&&(s=e.onclick,e.addEventListener("click",function(t){s(t)},!1),e.onclick=null)}}var e=navigator.userAgent.indexOf("Windows Phone")>=0,n=navigator.userAgent.indexOf("Android")>0&&!e,o=/iP(ad|hone|od)/.test(navigator.userAgent)&&!e,i=o&&/OS 4_\d(_\d)?/.test(navigator.userAgent),s=o&&/OS [6-7]_\d/.test(navigator.userAgent),r=navigator.userAgent.indexOf("BB10")>0;t.prototype.needsClick=function(t){switch(t.nodeName.toLowerCase()){case"button":case"select":case"textarea":if(t.disabled)return!0;break;case"input":if(o&&"file"===t.type||t.disabled)return!0;break;case"label":case"iframe":case"video":return!0}return/\bneedsclick\b/.test(t.className)},t.prototype.needsFocus=function(t){switch(t.nodeName.toLowerCase()){case"textarea":return!0;case"select":return!n;case"input":switch(t.type){case"button":case"checkbox":case"file":case"image":case"radio":case"submit":return!1}return!t.disabled&&!t.readOnly;default:return/\bneedsfocus\b/.test(t.className)}},t.prototype.sendClick=function(t,e){var n,o;document.activeElement&&document.activeElement!==t&&document.activeElement.blur(),o=e.changedTouches[0],n=document.createEvent("MouseEvents"),n.initMouseEvent(this.determineEventType(t),!0,!0,window,1,o.screenX,o.screenY,o.clientX,o.clientY,!1,!1,!1,!1,0,null),n.forwardedTouchEvent=!0,t.dispatchEvent(n)},t.prototype.determineEventType=function(t){return n&&"select"===t.tagName.toLowerCase()?"mousedown":"click"},t.prototype.focus=function(t){var e;o&&t.setSelectionRange&&0!==t.type.indexOf("date")&&"time"!==t.type&&"month"!==t.type?(e=t.value.length,t.setSelectionRange(e,e)):t.focus()},t.prototype.updateScrollParent=function(t){var e,n;if(!(e=t.fastClickScrollParent)||!e.contains(t)){n=t;do{if(n.scrollHeight>n.offsetHeight){e=n,t.fastClickScrollParent=n;break}n=n.parentElement}while(n)}e&&(e.fastClickLastScrollTop=e.scrollTop)},t.prototype.getTargetElementFromEventTarget=function(t){return t.nodeType===Node.TEXT_NODE?t.parentNode:t},t.prototype.onTouchStart=function(t){var e,n,s;if(t.targetTouches.length>1)return!0;if(e=this.getTargetElementFromEventTarget(t.target),n=t.targetTouches[0],o){if(s=window.getSelection(),s.rangeCount&&!s.isCollapsed)return!0;if(!i){if(n.identifier&&n.identifier===this.lastTouchIdentifier)return t.preventDefault(),!1;this.lastTouchIdentifier=n.identifier,this.updateScrollParent(e)}}return this.trackingClick=!0,this.trackingClickStart=t.timeStamp,this.targetElement=e,this.touchStartX=n.pageX,this.touchStartY=n.pageY,t.timeStamp-this.lastClickTime<this.tapDelay&&t.preventDefault(),!0},t.prototype.touchHasMoved=function(t){var e=t.changedTouches[0],n=this.touchBoundary;return Math.abs(e.pageX-this.touchStartX)>n||Math.abs(e.pageY-this.touchStartY)>n},t.prototype.onTouchMove=function(t){return!this.trackingClick||((this.targetElement!==this.getTargetElementFromEventTarget(t.target)||this.touchHasMoved(t))&&(this.trackingClick=!1,this.targetElement=null),!0)},t.prototype.findControl=function(t){return void 0!==t.control?t.control:t.htmlFor?document.getElementById(t.htmlFor):t.querySelector("button, input:not([type=hidden]), keygen, meter, output, progress, select, textarea")},t.prototype.onTouchEnd=function(t){var e,r,a,c,l,u=this.targetElement;if(!this.trackingClick)return!0;if(t.timeStamp-this.lastClickTime<this.tapDelay)return this.cancelNextClick=!0,!0;if(t.timeStamp-this.trackingClickStart>this.tapTimeout)return!0;if(this.cancelNextClick=!1,this.lastClickTime=t.timeStamp,r=this.trackingClickStart,this.trackingClick=!1,this.trackingClickStart=0,s&&(l=t.changedTouches[0],u=document.elementFromPoint(l.pageX-window.pageXOffset,l.pageY-window.pageYOffset)||u,u.fastClickScrollParent=this.targetElement.fastClickScrollParent),"label"===(a=u.tagName.toLowerCase())){if(e=this.findControl(u)){if(this.focus(u),n)return!1;u=e}}else if(this.needsFocus(u))return t.timeStamp-r>100||o&&window.top!==window&&"input"===a?(this.targetElement=null,!1):(this.focus(u),this.sendClick(u,t),o&&"select"===a||(this.targetElement=null,t.preventDefault()),!1);return!(!o||i||!(c=u.fastClickScrollParent)||c.fastClickLastScrollTop===c.scrollTop)||(this.needsClick(u)||(t.preventDefault(),this.sendClick(u,t)),!1)},t.prototype.onTouchCancel=function(){this.trackingClick=!1,this.targetElement=null},t.prototype.onMouse=function(t){return!this.targetElement||(!!t.forwardedTouchEvent||(!t.cancelable||(!(!this.needsClick(this.targetElement)||this.cancelNextClick)||(t.stopImmediatePropagation?t.stopImmediatePropagation():t.propagationStopped=!0,t.stopPropagation(),t.preventDefault(),!1))))},t.prototype.onClick=function(t){var e;return this.trackingClick?(this.targetElement=null,this.trackingClick=!1,!0):"submit"===t.target.type&&0===t.detail||(e=this.onMouse(t),e||(this.targetElement=null),e)},t.prototype.destroy=function(){var t=this.layer;n&&(t.removeEventListener("mouseover",this.onMouse,!0),t.removeEventListener("mousedown",this.onMouse,!0),t.removeEventListener("mouseup",this.onMouse,!0)),t.removeEventListener("click",this.onClick,!0),t.removeEventListener("touchstart",this.onTouchStart,!1),t.removeEventListener("touchmove",this.onTouchMove,!1),t.removeEventListener("touchend",this.onTouchEnd,!1),t.removeEventListener("touchcancel",this.onTouchCancel,!1)},t.notNeeded=function(t){var e,o,i,s;if(void 0===window.ontouchstart)return!0;if(o=+(/Chrome\/([0-9]+)/.exec(navigator.userAgent)||[,0])[1]){if(!n)return!0;if(e=document.querySelector("meta[name=viewport]")){if(-1!==e.content.indexOf("user-scalable=no"))return!0;if(o>31&&document.documentElement.scrollWidth<=window.outerWidth)return!0}}if(r&&(i=navigator.userAgent.match(/Version\/([0-9]*)\.([0-9]*)/),i[1]>=10&&i[2]>=3&&(e=document.querySelector("meta[name=viewport]")))){if(-1!==e.content.indexOf("user-scalable=no"))return!0;if(document.documentElement.scrollWidth<=window.outerWidth)return!0}return"none"===t.style.msTouchAction||"manipulation"===t.style.touchAction||(!!((s=+(/Firefox\/([0-9]+)/.exec(navigator.userAgent)||[,0])[1])>=27&&(e=document.querySelector("meta[name=viewport]"))&&(-1!==e.content.indexOf("user-scalable=no")||document.documentElement.scrollWidth<=window.outerWidth))||("none"===t.style.touchAction||"manipulation"===t.style.touchAction))},t.attach=function(e,n){return new t(e,n)},"function"==typeof define&&"object"==typeof define.amd&&define.amd?define(function(){return t}):"undefined"!=typeof module&&module.exports?(module.exports=t.attach,module.exports.FastClick=t):window.FastClick=t}(),function($){"use strict";$(document).on("click",".sl-button",function(){var t=$(this),e=t.attr("data-post-id"),n=t.attr("data-nonce"),o=t.attr("data-iscomment"),i;i=$("1"===o?".sl-comment-button-"+e:".sl-button-"+e);var s=i.next("#sl-loader");return""!==e&&$.ajax({type:"POST",url:simpleLikes.ajaxurl,data:{action:"process_simple_like",post_id:e,nonce:n,is_comment:o},beforeSend:function(){s.html('&nbsp;<div class="loader">Loading...</div>')},success:function(t){var e=t.icon,n=t.count;if(i.html(e+n),"unliked"===t.status){var o=simpleLikes.like;i.prop("title",o),i.removeClass("liked")}else{var r=simpleLikes.unlike;i.prop("title",r),i.addClass("liked")}s.empty()}}),!1})}(jQuery),jQuery(document).ready(function(){function t(){return"ontouchstart"in window}function e(){var t=$(".mc4wp-error").length>0?$(".mc4wp-error"):"";t?$(".ak_social_links").addClass("error-is-on"):$(".ak_social_links").removeClass("error-is-on"),console.log(t)}function n(){function t(t){t.preventDefault(),n.close()}function e(){n.toggle()}wrapper=document.getElementById("site-wrap")?document.getElementById("site-wrap"):"",menu=document.getElementById("mobile-top"),toggle=document.querySelector(".mobile-toggle");var n=new Slideout({panel:wrapper,menu:menu,padding:280,tolerance:70,ease:"step-start",side:"left"});n.on("beforeopen",function(){this.panel.classList.add("panel-open")}).on("open",function(){this.panel.addEventListener("click",t),toggle.classList.add("is-active"),toggle.setAttribute("aria-expanded","true")}).on("beforeclose",function(){this.panel.classList.remove("panel-open"),this.panel.removeEventListener("click",t)}).on("close",function(){toggle.classList.remove("is-active"),toggle.setAttribute("aria-expanded","false")}),toggle.addEventListener("click",e),n.on("translateend",function(){})}var o=jQuery("body"),i={Android:function(){return/Android/i.test(navigator.userAgent)},iOS:function(){return/iPhone|iPad|iPod/i.test(navigator.userAgent)},iPad:function(){return/iPad/i.test(navigator.userAgent)},Windows:function(){return/Windows Phone|iemobile|WPDesktop/i.test(navigator.userAgent)},Any:function(){return/Android|webOS|iPhone|iPad|iPod|BlackBerry|Windows Phone|iemobile|WPDesktop|Opera Mini/i.test(navigator.userAgent)}};(i.iOS()||i.Android()||i.Windows())&&o.addClass("touch-device"),$(".no-fouc").removeClass("no-fouc"),"addEventListener"in document&&document.addEventListener("DOMContentLoaded",function(){FastClick.attach(document.body)},!1),e(),n()});