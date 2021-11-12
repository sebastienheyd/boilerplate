<div class="d-flex align-items-center justify-content-center justify-content-md-end">
    <span class="mr-2 text-nowrap">Rechercher : </span>
    <div class="dt-search" data-target="#dt_{{ $slug }}">
        <div class="dt-search-autocomplete" style="display: none"></div>
        <div class="dt-search-facets d-flex"></div>
        <input class="dt-search-input" type="text" autocomplete="off" value="">
    </div>
    <x-boilerplate::select2 name="active" placeholder="Statut" :options="[1 => 'Activé', 0 => 'Désactivé']" class="form-control-sm" groupClass="ml-1 mb-0 select2-right" allowClear="true" />
    <x-boilerplate::select2 name="roles" placeholder="Roles" :options="[1 => 'Utilisateur du back-office', 0 => 'Administrateur']" class="form-control-sm" groupClass="ml-1 mb-0 select2-right" allowClear="true"/>
</div>