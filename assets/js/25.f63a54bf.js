(window.webpackJsonp=window.webpackJsonp||[]).push([[25],{347:function(t,a,s){"use strict";s.r(a);var n=s(25),e=Object(n.a)({},(function(){var t=this,a=t._self._c;return a("ContentSlotsDistributor",{attrs:{"slot-key":t.$parent.slotKey}},[a("h1",{attrs:{id:"usage"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#usage"}},[t._v("#")]),t._v(" Usage")]),t._v(" "),a("p",[t._v("Once the "),a("a",{attrs:{href:"configuration"}},[t._v("configuration")]),t._v(" is done, you are able to use the "),a("a",{attrs:{href:"https://laravel.com/docs/broadcasting",target:"_blank",rel:"noopener noreferrer"}},[t._v("Laravel broadcasting features"),a("OutboundLink")],1),t._v(" in your application.")]),t._v(" "),a("h3",{attrs:{id:"client-side"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#client-side"}},[t._v("#")]),t._v(" Client side")]),t._v(" "),a("p",[t._v("To use pusher in a page of your application you will must load "),a("code",[t._v("pusher-js")]),t._v(" and "),a("code",[t._v("laravel-echo")]),t._v(".")]),t._v(" "),a("p",[t._v("To do this, simply include the load view "),a("code",[t._v("boilerplate::load.pusher")]),t._v(" in pages where you need to listen broadcasted events by using the "),a("code",[t._v("@include")]),t._v(" blade directive :")]),t._v(" "),a("div",{staticClass:"language- extra-class"},[a("pre",{pre:!0,attrs:{class:"language-text"}},[a("code",[t._v("@include('boilerplate::load.pusher')\n")])])]),a("p",[t._v("Then you can use Laravel Echo :")]),t._v(" "),a("div",{staticClass:"language-html extra-class"},[a("pre",{pre:!0,attrs:{class:"language-html"}},[a("code",[a("span",{pre:!0,attrs:{class:"token tag"}},[a("span",{pre:!0,attrs:{class:"token tag"}},[a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("<")]),t._v("script")]),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(">")])]),a("span",{pre:!0,attrs:{class:"token script"}},[a("span",{pre:!0,attrs:{class:"token language-javascript"}},[t._v("\n"),a("span",{pre:!0,attrs:{class:"token function"}},[t._v("whenIsLoaded")]),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("(")]),a("span",{pre:!0,attrs:{class:"token string"}},[t._v("'echo'")]),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(",")]),t._v(" "),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("(")]),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(")")]),t._v(" "),a("span",{pre:!0,attrs:{class:"token operator"}},[t._v("=>")]),t._v(" "),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("{")]),t._v("\n    Echo"),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(".")]),a("span",{pre:!0,attrs:{class:"token function"}},[t._v("channel")]),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("(")]),a("span",{pre:!0,attrs:{class:"token string"}},[t._v("'MyChannelName'")]),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(")")]),t._v("\n        "),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(".")]),a("span",{pre:!0,attrs:{class:"token function"}},[t._v("listen")]),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("(")]),a("span",{pre:!0,attrs:{class:"token string"}},[t._v("'MyEvent'")]),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(",")]),t._v(" "),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("(")]),a("span",{pre:!0,attrs:{class:"token parameter"}},[t._v("e")]),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(")")]),t._v(" "),a("span",{pre:!0,attrs:{class:"token operator"}},[t._v("=>")]),t._v(" "),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("{")]),t._v("\n            console"),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(".")]),a("span",{pre:!0,attrs:{class:"token function"}},[t._v("log")]),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("(")]),t._v("e"),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(")")]),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(";")]),t._v("\n        "),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("}")]),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(")")]),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(";")]),t._v("\n"),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("}")]),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(")")]),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(";")]),t._v(" \n")])]),a("span",{pre:!0,attrs:{class:"token tag"}},[a("span",{pre:!0,attrs:{class:"token tag"}},[a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("</")]),t._v("script")]),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(">")])]),t._v("\n")])])]),a("blockquote",[a("p",[t._v("To be sure that "),a("code",[t._v("Echo")]),t._v(" is loaded, use the function "),a("code",[t._v("whenIsLoaded")]),t._v(". This is required to avoid errors when broadcasting is not used.")])]),t._v(" "),a("h3",{attrs:{id:"server-side"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#server-side"}},[t._v("#")]),t._v(" Server side")]),t._v(" "),a("p",[t._v("See "),a("a",{attrs:{href:"https://laravel.com/docs/broadcasting#using-example-application",target:"_blank",rel:"noopener noreferrer"}},[t._v("Using An Example Application"),a("OutboundLink")],1),t._v(" in the Laravel documentation.")])])}),[],!1,null,null,null);a.default=e.exports}}]);