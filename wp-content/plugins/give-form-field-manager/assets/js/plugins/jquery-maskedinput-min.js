!function(e){"function"==typeof define&&define.amd?define(["jquery"],e):e("object"==typeof exports?require("jquery"):jQuery)}(function($){var e,t=navigator.userAgent,n=/iphone/i.test(t),a=/chrome/i.test(t),i=/android/i.test(t);$.mask={definitions:{9:"[0-9]",a:"[A-Za-z]","*":"[A-Za-z0-9]"},autoclear:!0,dataName:"rawMaskFn",placeholder:"_"},$.fn.extend({caret:function(e,t){var n;if(0!==this.length&&!this.is(":hidden"))return"number"==typeof e?(t="number"==typeof t?t:e,this.each(function(){this.setSelectionRange?this.setSelectionRange(e,t):this.createTextRange&&(n=this.createTextRange(),n.collapse(!0),n.moveEnd("character",t),n.moveStart("character",e),n.select())})):(this[0].setSelectionRange?(e=this[0].selectionStart,t=this[0].selectionEnd):document.selection&&document.selection.createRange&&(n=document.selection.createRange(),e=0-n.duplicate().moveStart("character",-1e5),t=e+n.text.length),{begin:e,end:t})},unmask:function(){return this.trigger("unmask")},mask:function(t,r){var o,c,l,u,f,s,h,g;if(!t&&this.length>0){o=$(this[0]);var m=o.data($.mask.dataName);return m?m():void 0}return r=$.extend({autoclear:$.mask.autoclear,placeholder:$.mask.placeholder,completed:null},r),c=$.mask.definitions,l=[],u=h=t.length,f=null,$.each(t.split(""),function(e,t){"?"==t?(h--,u=e):c[t]?(l.push(new RegExp(c[t])),null===f&&(f=l.length-1),u>e&&(s=l.length-1)):l.push(null)}),this.trigger("unmask").each(function(){function o(){if(r.completed){for(var e=f;s>=e;e++)if(l[e]&&w[e]===m(e))return;r.completed.call(T)}}function m(e){return r.placeholder.charAt(e<r.placeholder.length?e:0)}function d(e){for(;++e<h&&!l[e];);return e}function p(e){for(;--e>=0&&!l[e];);return e}function v(e,t){var n,a;if(!(0>e)){for(n=e,a=d(t);h>n;n++)if(l[n]){if(!(h>a&&l[n].test(w[a])))break;w[n]=w[a],w[a]=m(a),a=d(a)}S(),T.caret(Math.max(f,e))}}function b(e){var t,n,a,i;for(t=e,n=m(e);h>t;t++)if(l[t]){if(a=d(t),i=w[t],w[t]=n,!(h>a&&l[a].test(i)))break;n=i}}function k(){var e=T.val(),t=T.caret();if(g&&g.length&&g.length>e.length){for(A(!0);t.begin>0&&!l[t.begin-1];)t.begin--;if(0===t.begin)for(;t.begin<f&&!l[t.begin];)t.begin++;T.caret(t.begin,t.begin)}else{for(A(!0);t.begin<h&&!l[t.begin];)t.begin++;T.caret(t.begin,t.begin)}o()}function y(){A(),T.val()!=D&&T.change()}function x(e){if(!T.prop("readonly")){var t,a,i,r=e.which||e.keyCode;g=T.val(),8===r||46===r||n&&127===r?(t=T.caret(),a=t.begin,i=t.end,i-a==0&&(a=46!==r?p(a):i=d(a-1),i=46===r?d(i):i),R(a,i),v(a,i-1),e.preventDefault()):13===r?y.call(this,e):27===r&&(T.val(D),T.caret(0,A()),e.preventDefault())}}function j(e){if(!T.prop("readonly")){var t,n,a,r=e.which||e.keyCode,c=T.caret();if(!(e.ctrlKey||e.altKey||e.metaKey||32>r)&&r&&13!==r){if(c.end-c.begin!=0&&(R(c.begin,c.end),v(c.begin,c.end-1)),t=d(c.begin-1),h>t&&(n=String.fromCharCode(r),l[t].test(n))){if(b(t),w[t]=n,S(),a=d(t),i){var u=function(){$.proxy($.fn.caret,T,a)()};setTimeout(u,0)}else T.caret(a);c.begin<=s&&o()}e.preventDefault()}}}function R(e,t){var n;for(n=e;t>n&&h>n;n++)l[n]&&(w[n]=m(n))}function S(){T.val(w.join(""))}function A(e){var t,n,a,i=T.val(),o=-1;for(t=0,a=0;h>t;t++)if(l[t]){for(w[t]=m(t);a++<i.length;)if(n=i.charAt(a-1),l[t].test(n)){w[t]=n,o=t;break}if(a>i.length){R(t+1,h);break}}else w[t]===i.charAt(a)&&a++,u>t&&(o=t);return e?S():u>o+1?r.autoclear||w.join("")===C?(T.val()&&T.val(""),R(0,h)):S():(S(),T.val(T.val().substring(0,o+1))),u?t:f}var T=$(this),w=$.map(t.split(""),function(e,t){return"?"!=e?c[e]?m(t):e:void 0}),C=w.join(""),D=T.val();T.data($.mask.dataName,function(){return $.map(w,function(e,t){return l[t]&&e!=m(t)?e:null}).join("")}),T.one("unmask",function(){T.off(".mask").removeData($.mask.dataName)}).on("focus.mask",function(){if(!T.prop("readonly")){clearTimeout(e);var n;D=T.val(),n=A(),e=setTimeout(function(){T.get(0)===document.activeElement&&(S(),n==t.replace("?","").length?T.caret(0,n):T.caret(n))},10)}}).on("blur.mask",y).on("keydown.mask",x).on("keypress.mask",j).on("input.mask paste.mask",function(){T.prop("readonly")||setTimeout(function(){var e=A(!0);T.caret(e),o()},0)}),a&&i&&T.off("input.mask").on("input.mask",k),A()})}})});