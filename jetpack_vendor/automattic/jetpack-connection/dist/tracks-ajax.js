!function(t,a){window.jpTracksAJAX=window.jpTracksAJAX||{};const c="dops:analytics"===localStorage.getItem("debug");window.jpTracksAJAX.record_ajax_event=function(n,e,r){const o={tracksNonce:a.jpTracksAJAX_nonce,action:"jetpack_tracks",tracksEventType:e,tracksEventName:n,tracksEventProp:r||!1};return t.ajax({type:"POST",url:a.ajaxurl,data:o,success:function(t){if(c)console.log("AJAX tracks event recorded: ",o,t)}})},t(document).ready((function(){t("body").on("click",".jptracks a, a.jptracks",(function(a){const c=t(a.target),n=c.closest(".jptracks"),e=n.attr("data-jptracks-name");if(void 0===e)return;const r=n.attr("data-jptracks-prop")||!1,o=c.attr("href"),s=c.get(0).target;let i=null;if(o&&s&&"_self"!==s)i=window.open("",s),i.opener=null;a.preventDefault(),window.jpTracksAJAX.record_ajax_event(e,"click",r).always((function(){if(o&&!c.hasClass("thickbox")){if(i)return void(i.location=o);window.location=o}}))}))}))}(jQuery,jpTracksAJAX);