<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link active" id="nav-gpt-generator" data-toggle="tab" data-target="#gpt-generator" type="button" role="tab" aria-controls="gpt-generator" aria-selected="true">@lang('boilerplate::gpt.tabs.wizard')</button>
        <button class="nav-link" id="nav-gpt-prompt" data-toggle="tab" data-target="#gpt-prompt" type="button" role="tab" aria-controls="gpt-prompt" aria-selected="false">@lang('boilerplate::gpt.tabs.prompt')</button>
        <button class="nav-link" id="nav-gpt-rewrite" data-toggle="tab" data-target="#gpt-rewrite" type="button" role="tab" aria-controls="gpt-rewrite" aria-selected="false" style="display: none">@lang('boilerplate::gpt.tabs.rewrite')</button>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="gpt-generator" role="tabpanel" aria-labelledby="nav-gpt-generator">
        @include('boilerplate::gpt.generator')
    </div>
    <div class="tab-pane fade" id="gpt-prompt" role="tabpanel" aria-labelledby="nav-profile-tab">
        @include('boilerplate::gpt.prompt')
    </div>
    <div class="tab-pane fade" id="gpt-rewrite" role="tabpanel" aria-labelledby="nav-profile-tab">
        @include('boilerplate::gpt.rewrite')
    </div>
</div>