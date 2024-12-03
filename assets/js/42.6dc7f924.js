(window.webpackJsonp=window.webpackJsonp||[]).push([[42],{360:function(t,e,a){"use strict";a.r(e);var s=a(25),n=Object(s.a)({},(function(){var t=this,e=t._self._c;return e("ContentSlotsDistributor",{attrs:{"slot-key":t.$parent.slotKey}},[e("h1",{attrs:{id:"app-php"}},[e("a",{staticClass:"header-anchor",attrs:{href:"#app-php"}},[t._v("#")]),t._v(" app.php")]),t._v(" "),e("p",[t._v("The "),e("code",[t._v("config/boilerplate/app.php")]),t._v(" file allows to define the general parameters of the application.")]),t._v(" "),e("hr"),t._v(" "),e("div",{staticClass:"language-php extra-class"},[e("pre",{pre:!0,attrs:{class:"language-php"}},[e("code",[e("span",{pre:!0,attrs:{class:"token php language-php"}},[e("span",{pre:!0,attrs:{class:"token delimiter important"}},[t._v("<?php")]),t._v("\n"),e("span",{pre:!0,attrs:{class:"token keyword"}},[t._v("return")]),t._v(" "),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("[")]),t._v("\n    "),e("span",{pre:!0,attrs:{class:"token comment"}},[t._v('// Backend routes prefix. Ex: "admin" => "http://..../admin"')]),t._v("\n    "),e("span",{pre:!0,attrs:{class:"token string single-quoted-string"}},[t._v("'prefix'")]),t._v("     "),e("span",{pre:!0,attrs:{class:"token operator"}},[t._v("=>")]),t._v(" "),e("span",{pre:!0,attrs:{class:"token string single-quoted-string"}},[t._v("'admin'")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(",")]),t._v("\n\n    "),e("span",{pre:!0,attrs:{class:"token comment"}},[t._v('// Backend domain if different as current domain. Ex: "admin.mydomain.tld"')]),t._v("\n    "),e("span",{pre:!0,attrs:{class:"token string single-quoted-string"}},[t._v("'domain'")]),t._v("     "),e("span",{pre:!0,attrs:{class:"token operator"}},[t._v("=>")]),t._v(" "),e("span",{pre:!0,attrs:{class:"token string single-quoted-string"}},[t._v("''")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(",")]),t._v("\n\n    "),e("span",{pre:!0,attrs:{class:"token comment"}},[t._v("// Redirect to this route after login")]),t._v("\n    "),e("span",{pre:!0,attrs:{class:"token string single-quoted-string"}},[t._v("'redirectTo'")]),t._v(" "),e("span",{pre:!0,attrs:{class:"token operator"}},[t._v("=>")]),t._v(" "),e("span",{pre:!0,attrs:{class:"token string single-quoted-string"}},[t._v("'boilerplate.dashboard'")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(",")]),t._v("\n\n    "),e("span",{pre:!0,attrs:{class:"token comment"}},[t._v("// Activating daily logs and showing log viewer")]),t._v("\n    "),e("span",{pre:!0,attrs:{class:"token string single-quoted-string"}},[t._v("'logs'")]),t._v("       "),e("span",{pre:!0,attrs:{class:"token operator"}},[t._v("=>")]),t._v(" "),e("span",{pre:!0,attrs:{class:"token constant boolean"}},[t._v("true")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(",")]),t._v("\n    \n    "),e("span",{pre:!0,attrs:{class:"token comment"}},[t._v("// When set to true, allows admins to view the site as a user of their choice")]),t._v("\n    "),e("span",{pre:!0,attrs:{class:"token string single-quoted-string"}},[t._v("'allowImpersonate'")]),t._v("  "),e("span",{pre:!0,attrs:{class:"token operator"}},[t._v("=>")]),t._v(" "),e("span",{pre:!0,attrs:{class:"token constant boolean"}},[t._v("false")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(",")]),t._v("\n"),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("]")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(";")]),t._v("\n")])])])]),e("hr"),t._v(" "),e("h2",{attrs:{id:"prefix"}},[e("a",{staticClass:"header-anchor",attrs:{href:"#prefix"}},[t._v("#")]),t._v(" prefix")]),t._v(" "),e("p",[t._v("The "),e("code",[t._v("prefix")]),t._v(" parameter will define the prefix of the application urls. This allows you to have no conflict if you need\nto have frontend urls separated.")]),t._v(" "),e("p",[t._v("The default value is "),e("code",[t._v('"admin"')]),t._v(" → http://mywebsite.tld/"),e("strong",[t._v("admin")])]),t._v(" "),e("blockquote",[e("p",[t._v("If your application does not have a front-end, you can define an empty string as "),e("code",[t._v("prefix")]),t._v(", this will then display the\nlogin form at the root of your website.")])]),t._v(" "),e("p",[t._v("See "),e("a",{attrs:{href:"https://laravel.com/docs/master/routing#route-group-prefixes",target:"_blank",rel:"noopener noreferrer"}},[t._v("Laravel documentation"),e("OutboundLink")],1),t._v(" for route prefixes.")]),t._v(" "),e("hr"),t._v(" "),e("h2",{attrs:{id:"domain"}},[e("a",{staticClass:"header-anchor",attrs:{href:"#domain"}},[t._v("#")]),t._v(" domain")]),t._v(" "),e("p",[t._v("The "),e("code",[t._v("domain")]),t._v(" parameter makes it possible to define a different and exclusive domain for the application.")]),t._v(" "),e("p",[t._v("The default value is "),e("code",[t._v('""')])]),t._v(" "),e("blockquote",[e("p",[t._v("If the parameter is empty, all domains will allow access to the backend, otherwise only the specified domain will allow\naccess.")])]),t._v(" "),e("p",[t._v("See "),e("a",{attrs:{href:"https://laravel.com/docs/master/routing#route-group-sub-domain-routing",target:"_blank",rel:"noopener noreferrer"}},[t._v("Laravel documentation"),e("OutboundLink")],1),t._v(" for sub-domain\nrouting.")]),t._v(" "),e("hr"),t._v(" "),e("h2",{attrs:{id:"redirectto"}},[e("a",{staticClass:"header-anchor",attrs:{href:"#redirectto"}},[t._v("#")]),t._v(" redirectTo")]),t._v(" "),e("p",[t._v("The "),e("code",[t._v("redirectTo")]),t._v(" parameter allows you to define the route to which you will be redirected after connecting.")]),t._v(" "),e("p",[t._v("The default value is "),e("code",[t._v('"boilerplate.dashboard"')])]),t._v(" "),e("hr"),t._v(" "),e("h2",{attrs:{id:"logs"}},[e("a",{staticClass:"header-anchor",attrs:{href:"#logs"}},[t._v("#")]),t._v(" logs")]),t._v(" "),e("p",[t._v("The "),e("code",[t._v("logs")]),t._v(" parameter allows you to define if you want to add "),e("code",[t._v("daily")]),t._v(" to the logging stack and enable the log viewer.")]),t._v(" "),e("blockquote",[t._v("\nLog viewer is only visible by administrators by default.\n")]),t._v(" "),e("hr"),t._v(" "),e("h2",{attrs:{id:"allowimpersonate"}},[e("a",{staticClass:"header-anchor",attrs:{href:"#allowimpersonate"}},[t._v("#")]),t._v(" allowImpersonate")]),t._v(" "),e("p",[t._v("When "),e("code",[t._v("allowImpersonate")]),t._v(" is set to true, admins are allowed to view the site as the user of their choice by using a\nswitch in the navbar.")]),t._v(" "),e("blockquote",[e("p",[t._v("You can't switch to an admin user")])])])}),[],!1,null,null,null);e.default=n.exports}}]);