# Users with a role

The role edit view (`admin/roles/{id}/edit`) provides a built-in DataTable listing all users that have the role being edited. The block is rendered below the **Parameters** card in the same column.

## Datatable

The DataTable is registered in the package under the slug `role_users` (class `Sebastienheyd\Boilerplate\Datatables\Admin\RoleUsersDatatable`).

It exposes the following columns:

- Avatar
- Status (active / inactive)
- Last name
- First name
- Email
- Last login (relative time)

The DataTable is filtered server-side on the `role_id` ajax parameter automatically passed by the role edit view.

## Permissions

Access to the DataTable is gated by the `roles_crud` permission (the same permission as the role edit view itself). Any AJAX request to `/admin/datatables/role_users` from a user without this permission returns HTTP 503.

## Rendering the DataTable in another view

The DataTable can be reused outside the role edit view by passing the target role id through the `:ajax` attribute of the `<x-boilerplate::datatable>` component:

```html
<x-boilerplate::datatable name="role_users" :ajax="['role_id' => $role->id]" />
```

The `:ajax` attribute injects extra parameters into the DataTables AJAX request — see the [datatable component](../components/datatable) documentation for details.
