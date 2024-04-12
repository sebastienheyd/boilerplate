# Laravel / AdminLTE 3 Boilerplate

[![Packagist](https://img.shields.io/packagist/v/sebastienheyd/boilerplate.svg?style=flat-square)](https://packagist.org/packages/sebastienheyd/boilerplate)
[![Build Status](https://scrutinizer-ci.com/g/sebastienheyd/boilerplate/badges/build.png?b=master&style=flat-square)](https://scrutinizer-ci.com/g/sebastienheyd/boilerplate/build-status/master)
[![StyleCI](https://github.styleci.io/repos/86598046/shield?branch=master&style=flat-square)](https://github.styleci.io/repos/86598046)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sebastienheyd/boilerplate/badges/quality-score.png?b=master&style=flat-square)](https://scrutinizer-ci.com/g/sebastienheyd/boilerplate/?branch=master)
![Laravel](https://img.shields.io/badge/Laravel-6.x%20→%208.x-green?logo=Laravel&style=flat-square)
[![Nb downloads](https://img.shields.io/packagist/dt/sebastienheyd/boilerplate.svg?style=flat-square)](https://packagist.org/packages/sebastienheyd/boilerplate)
[![MIT License](https://img.shields.io/github/license/sebastienheyd/boilerplate.svg?style=flat-square)](license.md)

This package serves as a basis for quickly creating a back-office.
It includes profile creation and his management, user management, roles, permissions, log viewing and ready to use [Blade components](components/card.html).

It also makes it easy to add other packages to extend the features, have a look to
[sebastienheyd/boilerplate-packager](https://github.com/sebastienheyd/boilerplate-packager) to quickly build your own
package for boilerplate.

Other packages to extend the features :
* [sebastienheyd/boilerplate-media-manager](https://github.com/sebastienheyd/boilerplate-media-manager)
* [sebastienheyd/boilerplate-email-editor](https://github.com/sebastienheyd/boilerplate-email-editor)

---
<a :href="$withBase('/assets/img/register.png')" class="img-link"><img :src="$withBase('/assets/img/register.png')" style="max-width:100%;height:90px;margin-right:.5rem"/></a>
<a :href="$withBase('/assets/img/login.png')" class="img-link"><img :src="$withBase('/assets/img/login.png')" style="max-width:100%;height:90px;margin-right:.5rem"/></a>
<a :href="$withBase('/assets/img/add_user.png')" class="img-link"><img :src="$withBase('/assets/img/add_user.png')" style="max-width:100%;height:90px;margin-right:.5rem" /></a>
<a :href="$withBase('/assets/img/role.png')" class="img-link"><img :src="$withBase('/assets/img/role.png')" style="max-width:100%;height:90px;margin-right:.5rem" /></a>
<a :href="$withBase('/assets/img/logs.png')" class="img-link"><img :src="$withBase('/assets/img/logs.png')" style="max-width:100%;height:90px;margin-right:.5rem" /></a>
<a :href="$withBase('/assets/img/theme_red.png')" class="img-link"><img :src="$withBase('/assets/img/theme_red.png')" style="max-width:100%;height:90px;margin-right:.5rem" /></a>
<a :href="$withBase('/assets/img/dashboard.png')" class="img-link"><img :src="$withBase('/assets/img/dashboard.png')" style="max-width:100%;height:90px;margin-right:.5rem" /></a>

## Features

* Configurable [backend theme](howto/change_theme.html) and [Blade components](components/card.html) for [AdminLTE 3](https://adminlte.io/docs/3.0/)
* [Text generation with GPT in TinyMCE](howto/generate_text_gpt.html) with the OpenAI API
* [Customizable dashboard](dashboard/generate_widget.html) with widgets
* Css framework [Bootstrap 4](https://getbootstrap.com/)
* Icons by [Font Awesome 5](https://fontawesome.com/)
* Role-based permissions support by [santigarcor/laratrust](https://github.com/santigarcor/laratrust)
* Forms & Html helpers by [spatie/laravel-html](https://github.com/spatie/laravel-html)
* Menu dynamically builded by [lavary/laravel-menu](https://github.com/lavary/laravel-menu)
* Menu items activated by [sebastienheyd/active](https://github.com/sebastienheyd/active)
* Server-side datatables methods provided by [yajra/laravel-datatables](https://yajrabox.com/docs/laravel-datatables)
* Image manipulation by [intervention/image](https://github.com/intervention/image)
* Logs visualization by [arcanedev/log-viewer](https://github.com/ARCANEDEV/LogViewer)
* Gravatar import by [creativeorange/gravatar](https://github.com/creativeorange/gravatar)
* Default languages from [laravel-lang/lang](https://github.com/Laravel-Lang/lang)
* Javascript session keep-alive
* Dark mode
* [Localized](https://github.com/sebastienheyd/boilerplate/tree/master/src/resources/lang)
