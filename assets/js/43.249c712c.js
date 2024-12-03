(window.webpackJsonp=window.webpackJsonp||[]).push([[43],{361:function(t,s,e){"use strict";e.r(s);var a=e(25),r=Object(a.a)({},(function(){var t=this,s=t._self._c;return s("ContentSlotsDistributor",{attrs:{"slot-key":t.$parent.slotKey}},[s("h1",{attrs:{id:"auth-php"}},[s("a",{staticClass:"header-anchor",attrs:{href:"#auth-php"}},[t._v("#")]),t._v(" auth.php")]),t._v(" "),s("p",[t._v("The "),s("code",[t._v("config/boilerplate/auth.php")]),t._v(" file allows to define the authentication and registration parameters of the application.")]),t._v(" "),s("hr"),t._v(" "),s("div",{staticClass:"language-php extra-class"},[s("pre",{pre:!0,attrs:{class:"language-php"}},[s("code",[s("span",{pre:!0,attrs:{class:"token php language-php"}},[s("span",{pre:!0,attrs:{class:"token delimiter important"}},[t._v("<?php")]),t._v("\n"),s("span",{pre:!0,attrs:{class:"token keyword"}},[t._v("return")]),t._v(" "),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("[")]),t._v("\n    "),s("span",{pre:!0,attrs:{class:"token string single-quoted-string"}},[t._v("'register'")]),t._v("      "),s("span",{pre:!0,attrs:{class:"token operator"}},[t._v("=>")]),t._v(" "),s("span",{pre:!0,attrs:{class:"token constant boolean"}},[t._v("false")]),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(",")]),t._v("           "),s("span",{pre:!0,attrs:{class:"token comment"}},[t._v("// Allow to register new users on backend login page")]),t._v("\n    "),s("span",{pre:!0,attrs:{class:"token string single-quoted-string"}},[t._v("'register_role'")]),t._v(" "),s("span",{pre:!0,attrs:{class:"token operator"}},[t._v("=>")]),t._v(" "),s("span",{pre:!0,attrs:{class:"token string single-quoted-string"}},[t._v("'backend_user'")]),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(",")]),t._v("  "),s("span",{pre:!0,attrs:{class:"token comment"}},[t._v("// Given role to new users (except the first one who is admin)")]),t._v("\n    "),s("span",{pre:!0,attrs:{class:"token string single-quoted-string"}},[t._v("'verify_email'")]),t._v("  "),s("span",{pre:!0,attrs:{class:"token operator"}},[t._v("=>")]),t._v(" "),s("span",{pre:!0,attrs:{class:"token constant boolean"}},[t._v("false")]),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(",")]),t._v("           "),s("span",{pre:!0,attrs:{class:"token comment"}},[t._v("// Users must have a valid e-mail (a verification email is sent when a user registers)")]),t._v("\n    "),s("span",{pre:!0,attrs:{class:"token string single-quoted-string"}},[t._v("'providers'")]),t._v("     "),s("span",{pre:!0,attrs:{class:"token operator"}},[t._v("=>")]),t._v(" "),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("[")]),t._v("\n        "),s("span",{pre:!0,attrs:{class:"token string single-quoted-string"}},[t._v("'users'")]),t._v(" "),s("span",{pre:!0,attrs:{class:"token operator"}},[t._v("=>")]),t._v(" "),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("[")]),t._v("\n            "),s("span",{pre:!0,attrs:{class:"token string single-quoted-string"}},[t._v("'driver'")]),t._v(" "),s("span",{pre:!0,attrs:{class:"token operator"}},[t._v("=>")]),t._v(" "),s("span",{pre:!0,attrs:{class:"token string single-quoted-string"}},[t._v("'eloquent'")]),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(",")]),t._v("\n            "),s("span",{pre:!0,attrs:{class:"token string single-quoted-string"}},[t._v("'model'")]),t._v("  "),s("span",{pre:!0,attrs:{class:"token operator"}},[t._v("=>")]),t._v(" "),s("span",{pre:!0,attrs:{class:"token class-name class-name-fully-qualified static-context"}},[t._v("Sebastienheyd"),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("\\")]),t._v("Boilerplate"),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("\\")]),t._v("Models"),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("\\")]),t._v("User")]),s("span",{pre:!0,attrs:{class:"token operator"}},[t._v("::")]),s("span",{pre:!0,attrs:{class:"token keyword"}},[t._v("class")]),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(",")]),t._v("\n            "),s("span",{pre:!0,attrs:{class:"token string single-quoted-string"}},[t._v("'table'")]),t._v("  "),s("span",{pre:!0,attrs:{class:"token operator"}},[t._v("=>")]),t._v(" "),s("span",{pre:!0,attrs:{class:"token string single-quoted-string"}},[t._v("'users'")]),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(",")]),t._v("\n        "),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("]")]),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(",")]),t._v("\n    "),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("]")]),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(",")]),t._v("\n    "),s("span",{pre:!0,attrs:{class:"token string single-quoted-string"}},[t._v("'throttle'")]),t._v(" "),s("span",{pre:!0,attrs:{class:"token operator"}},[t._v("=>")]),t._v(" "),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("[")]),t._v("\n        "),s("span",{pre:!0,attrs:{class:"token string single-quoted-string"}},[t._v("'maxAttempts'")]),t._v(" "),s("span",{pre:!0,attrs:{class:"token operator"}},[t._v("=>")]),t._v(" "),s("span",{pre:!0,attrs:{class:"token number"}},[t._v("3")]),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(",")]),t._v("            "),s("span",{pre:!0,attrs:{class:"token comment"}},[t._v("// Maximum number of login attempts to allow")]),t._v("\n        "),s("span",{pre:!0,attrs:{class:"token string single-quoted-string"}},[t._v("'decayMinutes'")]),t._v(" "),s("span",{pre:!0,attrs:{class:"token operator"}},[t._v("=>")]),t._v(" "),s("span",{pre:!0,attrs:{class:"token number"}},[t._v("1")]),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(",")]),t._v("           "),s("span",{pre:!0,attrs:{class:"token comment"}},[t._v("// Number of minutes to wait before login will be available again")]),t._v("\n    "),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("]")]),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(",")]),t._v("\n"),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("]")]),s("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(";")]),t._v("\n")])])])]),s("hr"),t._v(" "),s("h2",{attrs:{id:"register"}},[s("a",{staticClass:"header-anchor",attrs:{href:"#register"}},[t._v("#")]),t._v(" register")]),t._v(" "),s("p",[t._v("If "),s("code",[t._v("register")]),t._v(" is set to "),s("code",[t._v("true")]),t._v(" then it is possible for new users to register themselves to access the application.")]),t._v(" "),s("p",[t._v('A link "Register a new user" appears on the login page.')]),t._v(" "),s("p",[t._v("The default value is "),s("code",[t._v("false")]),t._v(".")]),t._v(" "),s("hr"),t._v(" "),s("h2",{attrs:{id:"register-role"}},[s("a",{staticClass:"header-anchor",attrs:{href:"#register-role"}},[t._v("#")]),t._v(" register_role")]),t._v(" "),s("p",[t._v("The "),s("code",[t._v("register_role")]),t._v(' parameter allows to set the default role when a new user registers (if the "register" parameter\nabove is set to "true").')]),t._v(" "),s("p",[t._v("The default value is "),s("code",[t._v("backend_user")])]),t._v(" "),s("blockquote",[s("p",[t._v("The first user created will always have the role admin")])]),t._v(" "),s("hr"),t._v(" "),s("h2",{attrs:{id:"verify-email"}},[s("a",{staticClass:"header-anchor",attrs:{href:"#verify-email"}},[t._v("#")]),t._v(" verify_email")]),t._v(" "),s("p",[t._v("If "),s("code",[t._v("verify_email")]),t._v(" is set to "),s("code",[t._v("true")]),t._v(" all new registered users must confirm their e-mail address before accessing the application.")]),t._v(" "),s("p",[t._v("To do this, an e-mail is sent in which each user must click to confirm his address.")]),t._v(" "),s("p",[t._v("The default value is "),s("code",[t._v("false")]),t._v(".")]),t._v(" "),s("blockquote",[s("p",[t._v("Only the first user (admin) and users invited to join the admin by e-mail will not be asked to confirm their e-mails.")])]),t._v(" "),s("hr"),t._v(" "),s("h2",{attrs:{id:"providers"}},[s("a",{staticClass:"header-anchor",attrs:{href:"#providers"}},[t._v("#")]),t._v(" providers")]),t._v(" "),s("p",[t._v("The "),s("code",[t._v("providers")]),t._v(" parameter overwrites "),s("code",[t._v("config/auth.php")]),t._v(" to use boilerplate's user model\n("),s("code",[t._v("Sebastienheyd\\Boilerplate\\Models\\User::class")]),t._v(") instead of the default Laravel one ("),s("code",[t._v("App\\User::class")]),t._v(").")]),t._v(" "),s("p",[t._v("This setting allows you to define your own user class or your own provider if you want to add features.")]),t._v(" "),s("hr"),t._v(" "),s("h2",{attrs:{id:"throttle"}},[s("a",{staticClass:"header-anchor",attrs:{href:"#throttle"}},[t._v("#")]),t._v(" throttle")]),t._v(" "),s("p",[t._v("This configuration section allows you to set how many times a user can try to login unsuccessfully, and how many minutes\nhe must wait until he can try again.")])])}),[],!1,null,null,null);s.default=r.exports}}]);