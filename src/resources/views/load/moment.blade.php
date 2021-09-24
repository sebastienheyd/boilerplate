@once
<script src="{!! mix('/plugins/moment/moment-with-locales.min.js', '/assets/vendor/boilerplate') !!}"></script>
<script>moment.locale('{{ App::getLocale() }}')</script>
@endonce