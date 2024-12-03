(window.webpackJsonp=window.webpackJsonp||[]).push([[117],{435:function(t,e,a){"use strict";a.r(e);var s=a(25),n=Object(s.a)({},(function(){var t=this,e=t._self._c;return e("ContentSlotsDistributor",{attrs:{"slot-key":t.$parent.slotKey}},[e("h1",{attrs:{id:"add-items-to-the-menu"}},[e("a",{staticClass:"header-anchor",attrs:{href:"#add-items-to-the-menu"}},[t._v("#")]),t._v(" Add items to the menu")]),t._v(" "),e("p",[t._v("Menu items are supported by the "),e("a",{attrs:{href:"https://github.com/lavary/laravel-menu",target:"_blank",rel:"noopener noreferrer"}},[t._v("lavary/laravel-menu"),e("OutboundLink")],1),t._v(" and "),e("a",{attrs:{href:"https://github.com/sebastienheyd/active",target:"_blank",rel:"noopener noreferrer"}},[t._v("sebastienheyd/active"),e("OutboundLink")],1),t._v(" packages.")]),t._v(" "),e("p",[t._v("To add items to the main menu, boilerplate will use providers.")]),t._v(" "),e("h2",{attrs:{id:"generating-a-new-menu-items-provider"}},[e("a",{staticClass:"header-anchor",attrs:{href:"#generating-a-new-menu-items-provider"}},[t._v("#")]),t._v(" Generating a new menu items provider")]),t._v(" "),e("p",[t._v("This package provides an artisan command to quickly generate a menu items provider.")]),t._v(" "),e("p",[t._v("This command will generate the provider file in the "),e("code",[t._v("app/Menu")]),t._v(" folder, if the folder does not exists, it will be created.")]),t._v(" "),e("div",{staticClass:"language-bash extra-class"},[e("pre",{pre:!0,attrs:{class:"language-bash"}},[e("code",[t._v("php artisan boilerplate:menuitem "),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("{")]),t._v("name"),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("}")]),t._v(" "),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("{")]),t._v("-s"),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("}")]),t._v(" "),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("{")]),t._v("-o"),e("span",{pre:!0,attrs:{class:"token operator"}},[t._v("=")]),e("span",{pre:!0,attrs:{class:"token number"}},[t._v("100")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("}")]),t._v("\n")])])]),e("table",[e("thead",[e("tr",[e("th",[t._v("option / argument")]),t._v(" "),e("th",[t._v("description")])])]),t._v(" "),e("tbody",[e("tr",[e("td",[t._v("name")]),t._v(" "),e("td",[t._v("Menu item name")])]),t._v(" "),e("tr",[e("td",[t._v("-s --submenu")]),t._v(" "),e("td",[t._v("Menu item must have sub item(s) ?")])]),t._v(" "),e("tr",[e("td",[t._v("-o --order")]),t._v(" "),e("td",[t._v("Menu item order in the backend menu, default is 100")])])])]),t._v(" "),e("p",[t._v("Once generated, the class file can be edited to customize the items, see "),e("a",{attrs:{href:"#menu-items-provider"}},[t._v("Menu item provider")])]),t._v(" "),e("p",[t._v("You can also add your own providers by adding their classnames to the array of providers in the configuration file\n"),e("code",[t._v("config/boilerplate/menu.php")]),t._v(". This can be useful if you don't want to use the default directory "),e("code",[t._v("app/Menu")]),t._v(" in your\napplication.")]),t._v(" "),e("hr"),t._v(" "),e("h2",{attrs:{id:"for-package-developpers"}},[e("a",{staticClass:"header-anchor",attrs:{href:"#for-package-developpers"}},[t._v("#")]),t._v(" For package developpers")]),t._v(" "),e("p",[t._v("Menu items providers can be added by using the "),e("code",[t._v("boilerplate.menu.items")]),t._v(" singleton in your\npackage service provider. Example :")]),t._v(" "),e("div",{staticClass:"language-php extra-class"},[e("pre",{pre:!0,attrs:{class:"language-php"}},[e("code",[e("span",{pre:!0,attrs:{class:"token keyword"}},[t._v("public")]),t._v(" "),e("span",{pre:!0,attrs:{class:"token keyword"}},[t._v("function")]),t._v(" "),e("span",{pre:!0,attrs:{class:"token function-definition function"}},[t._v("register")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("(")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(")")]),t._v("\n"),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("{")]),t._v("\n    "),e("span",{pre:!0,attrs:{class:"token function"}},[t._v("app")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("(")]),e("span",{pre:!0,attrs:{class:"token string single-quoted-string"}},[t._v("'boilerplate.menu.items'")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(")")]),e("span",{pre:!0,attrs:{class:"token operator"}},[t._v("->")]),e("span",{pre:!0,attrs:{class:"token function"}},[t._v("registerMenuItem")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("(")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("[")]),t._v("\n        "),e("span",{pre:!0,attrs:{class:"token class-name class-name-fully-qualified static-context"}},[e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("\\")]),t._v("MyPackage"),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("\\")]),t._v("MyNamespace"),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("\\")]),t._v("MyMenu")]),e("span",{pre:!0,attrs:{class:"token operator"}},[t._v("::")]),e("span",{pre:!0,attrs:{class:"token keyword"}},[t._v("class")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(",")]),t._v("\n    "),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("]")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(")")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(";")]),t._v("\n"),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("}")]),t._v("\n")])])]),e("hr"),t._v(" "),e("h2",{attrs:{id:"menu-items-provider"}},[e("a",{staticClass:"header-anchor",attrs:{href:"#menu-items-provider"}},[t._v("#")]),t._v(" Menu items provider")]),t._v(" "),e("p",[t._v("Once generated menu items provider are used to build the back-office main menu.")]),t._v(" "),e("p",[t._v("You will find a method "),e("code",[t._v("make")]),t._v(" inside where items are added.")]),t._v(" "),e("p",[t._v("To add an item at the root of the menu, you have to call the "),e("code",[t._v("add")]),t._v(" method on "),e("code",[t._v("$menu")]),t._v(" (instance of "),e("code",[t._v("Sebastienheyd\\Boilerplate\\Menu\\Builder")]),t._v(")")]),t._v(" "),e("div",{staticClass:"language-php extra-class"},[e("pre",{pre:!0,attrs:{class:"language-php"}},[e("code",[e("span",{pre:!0,attrs:{class:"token keyword"}},[t._v("public")]),t._v(" "),e("span",{pre:!0,attrs:{class:"token keyword"}},[t._v("function")]),t._v(" "),e("span",{pre:!0,attrs:{class:"token function-definition function"}},[t._v("make")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("(")]),e("span",{pre:!0,attrs:{class:"token class-name type-declaration"}},[t._v("Builder")]),t._v(" "),e("span",{pre:!0,attrs:{class:"token variable"}},[t._v("$menu")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(")")]),t._v("\n"),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("{")]),t._v("\n    "),e("span",{pre:!0,attrs:{class:"token variable"}},[t._v("$menu")]),e("span",{pre:!0,attrs:{class:"token operator"}},[t._v("->")]),e("span",{pre:!0,attrs:{class:"token function"}},[t._v("add")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("(")]),e("span",{pre:!0,attrs:{class:"token variable"}},[t._v("$label")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(",")]),t._v(" "),e("span",{pre:!0,attrs:{class:"token variable"}},[t._v("$options")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(")")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(";")]),t._v("\n"),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("}")]),t._v("\n")])])]),e("p",[t._v("The "),e("code",[t._v("label")]),t._v(" can be a string or a locale string. The locale string will be translated if exists.")]),t._v(" "),e("p",[t._v("Options are :")]),t._v(" "),e("table",[e("thead",[e("tr",[e("th",[t._v("Name")]),t._v(" "),e("th",[t._v("Description")])])]),t._v(" "),e("tbody",[e("tr",[e("td",[e("strong",[t._v("route")])]),t._v(" "),e("td",[t._v("The menu item link will point on this route, useless on items with sub items.")])]),t._v(" "),e("tr",[e("td",[e("strong",[t._v("permission")])]),t._v(" "),e("td",[t._v("Comma separated list of permissions required to display the menu item.")])]),t._v(" "),e("tr",[e("td",[e("strong",[t._v("role")])]),t._v(" "),e("td",[t._v("Comma separated list of roles required to display the menu item. Admin is setted by default.")])]),t._v(" "),e("tr",[e("td",[e("strong",[t._v("active")])]),t._v(" "),e("td",[t._v("Comma separated list of routes or route wildcard (eg: "),e("code",[t._v("boilerplate.users.*")]),t._v("). When one route is corresponding to the current one, item will be activated")])]),t._v(" "),e("tr",[e("td",[e("strong",[t._v("icon")])]),t._v(" "),e("td",[t._v("Font awesome icon or image URL to use. You can use by default solid icons ("),e("code",[t._v("fas")]),t._v(") by just set the icon name (eg: "),e("code",[t._v("square")]),t._v("). Or you can set the full classes to use (eg: "),e("code",[t._v("far fa-square")]),t._v("). "),e("a",{attrs:{href:"https://fontawesome.com/icons?d=gallery&m=free",target:"_blank",rel:"noopener noreferrer"}},[t._v("See icons here"),e("OutboundLink")],1),t._v(".")])]),t._v(" "),e("tr",[e("td",[e("strong",[t._v("order")])]),t._v(" "),e("td",[t._v("Order in the main menu (default = 100), the dashboard is level 0, users management is level 1000.")])])])]),t._v(" "),e("p",[t._v("To add a sub item to an item :")]),t._v(" "),e("div",{staticClass:"language-php extra-class"},[e("pre",{pre:!0,attrs:{class:"language-php"}},[e("code",[e("span",{pre:!0,attrs:{class:"token keyword"}},[t._v("public")]),t._v(" "),e("span",{pre:!0,attrs:{class:"token keyword"}},[t._v("function")]),t._v(" "),e("span",{pre:!0,attrs:{class:"token function-definition function"}},[t._v("make")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("(")]),e("span",{pre:!0,attrs:{class:"token class-name type-declaration"}},[t._v("Builder")]),t._v(" "),e("span",{pre:!0,attrs:{class:"token variable"}},[t._v("$menu")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(")")]),t._v("\n"),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("{")]),t._v("\n    "),e("span",{pre:!0,attrs:{class:"token variable"}},[t._v("$item")]),t._v(" "),e("span",{pre:!0,attrs:{class:"token operator"}},[t._v("=")]),t._v(" "),e("span",{pre:!0,attrs:{class:"token variable"}},[t._v("$menu")]),e("span",{pre:!0,attrs:{class:"token operator"}},[t._v("->")]),e("span",{pre:!0,attrs:{class:"token function"}},[t._v("add")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("(")]),e("span",{pre:!0,attrs:{class:"token variable"}},[t._v("$label")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(",")]),t._v(" "),e("span",{pre:!0,attrs:{class:"token variable"}},[t._v("$options")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(")")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(";")]),t._v("\n    \n    "),e("span",{pre:!0,attrs:{class:"token comment"}},[t._v("// Adding the sub item to the item above.")]),t._v("\n    "),e("span",{pre:!0,attrs:{class:"token variable"}},[t._v("$item")]),e("span",{pre:!0,attrs:{class:"token operator"}},[t._v("->")]),e("span",{pre:!0,attrs:{class:"token function"}},[t._v("add")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("(")]),e("span",{pre:!0,attrs:{class:"token variable"}},[t._v("$label")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(",")]),t._v(" "),e("span",{pre:!0,attrs:{class:"token variable"}},[t._v("$options")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(")")]),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(";")]),t._v("\n"),e("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("}")]),t._v("\n")])])])])}),[],!1,null,null,null);e.default=n.exports}}]);