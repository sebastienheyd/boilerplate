# Assign direct permissions to a user

In addition to permissions inherited from roles, you can assign **direct permissions** to a specific user. A direct permission is granted to one user only, without going through a role.

This is useful when a single user needs an extra capability that does not justify creating a new role or assigning a broader existing one.

::: tip
Direct permissions are **additive only**. They add to the permissions inherited from the user's roles, they never revoke them.
:::

## Role permissions vs direct permissions

| Aspect              | Role permission                                  | Direct permission                          |
|---------------------|--------------------------------------------------|--------------------------------------------|
| Granted to          | Every user holding the role                      | One specific user                          |
| Managed from        | Role edit screen (`Roles`)                       | User edit / create screen (`Users`)        |
| Stored in           | `permission_role` table                          | `permission_user` table                    |
| Typical use case    | Capability shared by a group of users            | One-off capability for a single user       |
| Revocation          | Remove the permission from the role              | Uncheck the permission on the user form    |

Both kinds are taken into account by `hasPermission()` and the Laratrust `@permission` Blade directive.

## Assign direct permissions from the admin UI

The user create and edit forms display a **Permissions** card next to the **Roles** card. The card lists every permission available in the application, grouped by category.

To assign a direct permission to a user:

1. Open the user edit form (or the user create form).
2. In the **Permissions** card, check the permissions you want to grant directly.
3. Click **Save**.

The selected permissions are persisted in the `permission_user` table through a `sync()` operation. Unchecking a permission and saving removes it from the user.

### Permissions inherited from roles

When a role is checked on the user form, every permission belonging to that role is automatically displayed as **checked and disabled** in the Permissions card. This makes inherited permissions visible while preventing the admin from granting a permission that is already covered by a role.

If the admin unchecks the role, the permissions inherited from it become enabled again, and the previously selected direct permissions are restored to their original state.

## Visibility in the users list

The users datatable (Admin → Users) exposes an **Additional permissions** column next to **Roles**. It lists each user's direct permissions only — permissions inherited from roles are not shown here, to keep the two concepts distinct and avoid duplicating the Roles column.

A dropdown filter on the column header lets you list every user that has a specific permission assigned directly. Users who own the same permission only through a role are excluded from the filtered result.

## Read direct permissions in code

Direct permissions are exposed through the standard Laratrust API on the `User` model.

Check whether a user has a permission (direct **or** role-inherited):

```php
Auth::user()->hasPermission('invoices_read');
```

Access the direct permissions collection only:

```php
$user->permissions; // Collection of Permission models attached directly
```

Sync direct permissions programmatically:

```php
$user->permissions()->sync([$permissionId1, $permissionId2]);
```

::: warning
`$user->permissions` returns only the **direct** permissions. To get the consolidated set of effective permissions (direct + inherited), iterate over `$user->roles` and merge with `$user->permissions`, or rely on `hasPermission()` for individual checks.
:::

## Edge cases and limitations

- **Admin users** already have every permission through the `admin` role. Assigning direct permissions to an admin user is a no-op in practice.
- **Duplication with a role permission** is allowed but redundant. A permission already granted by a role does not need to be checked as a direct permission. The UI flags this automatically (see *Permissions inherited from roles* above).
- **Removal** is done by simply unchecking the permission and saving the form. The underlying `sync()` call removes the row from `permission_user`.
- **Negative permissions are not supported**. You cannot revoke a role permission for a specific user from this screen. If you need fine-grained revocation, split the role instead.
- **Permission definitions** are still managed via the console command `php artisan boilerplate:permission` (see [Use roles and permissions](./add_permissions.md)). The user form only assigns existing permissions, it does not create new ones.
