@push('js')
<script>
(function () {
    var roleInputs = document.querySelectorAll('input[name^="roles["]');
    var permInputs = document.querySelectorAll('input[name^="permission["]');
    if (roleInputs.length === 0 || permInputs.length === 0) return;

    function computeInherited() {
        var ids = {};
        var all = false;
        for (var i = 0; i < roleInputs.length; i++) {
            var input = roleInputs[i];
            if (!input.checked) continue;
            if (input.dataset.admin === '1') all = true;
            var list = (input.dataset.permissions || '').split(',');
            for (var j = 0; j < list.length; j++) {
                if (list[j] !== '') ids[list[j]] = true;
            }
        }
        return { ids: ids, all: all };
    }

    function refresh() {
        var inherited = computeInherited();
        for (var i = 0; i < permInputs.length; i++) {
            var input = permInputs[i];
            var id = input.id.replace(/^permission_/, '');
            var isInherited = inherited.all || !!inherited.ids[id];
            var direct = input.dataset.direct === '1';
            input.disabled = isInherited;
            input.checked = isInherited || direct;
        }
    }

    for (var i = 0; i < roleInputs.length; i++) {
        roleInputs[i].addEventListener('change', refresh);
    }
    refresh();
})();
</script>
@endpush
