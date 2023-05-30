<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link active" id="nav-gpt-compose" data-toggle="tab" data-target="#gpt-compose" type="button" role="tab" aria-controls="gpt-compose" aria-selected="true">Composer</button>
        <button class="nav-link" id="nav-gpt-prompt" data-toggle="tab" data-target="#gpt-prompt" type="button" role="tab" aria-controls="gpt-prompt" aria-selected="false">Saisie brute</button>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="gpt-compose" role="tabpanel" aria-labelledby="nav-gpt-compose">
        @include('boilerplate::gpt.form')
    </div>
    <div class="tab-pane fade" id="gpt-prompt" role="tabpanel" aria-labelledby="nav-profile-tab">2</div>
</div>