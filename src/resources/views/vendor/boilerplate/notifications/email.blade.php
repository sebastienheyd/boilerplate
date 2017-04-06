@component('boilerplate::notifications.message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level == 'error')
# Whoops!
@else
# {{ __('boilerplate::notifications.hello') }}
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@if (isset($actionText))
<?php
    switch ($level) {
        case 'success':
            $color = 'green';
            break;
        case 'error':
            $color = 'red';
            break;
        default:
            $color = 'blue';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endif

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

<!-- Salutation -->
@if (! empty($salutation))
{!! $salutation !!}
@else
{!! __('boilerplate::notifications.salutation', ['name' => config('app.name') ]) !!}
@endif

<!-- Subcopy -->
@if (isset($actionText))
@component('mail::subcopy')
{{ __('boilerplate::notifications.subcopy', ['actionText' => $actionText, 'actionUrl' => $actionUrl]) }}
@endcomponent
@endif
@endcomponent
