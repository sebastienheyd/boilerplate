<div id="demo-theme">
    <div class="row">
        <div class="col-xl-6">
            @component('boilerplate::card', ['title' => 'Tables, badges and pagination'])
                <p>Content text with <a href="#demo-theme">a link</a> and <span class="text-muted">muted text</span>.</p>
                <table class="table table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a href="#demo-theme">John Doe</a></td>
                            <td><span class="badge badge-primary">Admin</span></td>
                            <td><span class="badge badge-success">Active</span></td>
                        </tr>
                        <tr>
                            <td><a href="#demo-theme">Jane Roe</a></td>
                            <td><span class="badge badge-primary">Backend user</span></td>
                            <td><span class="badge badge-warning">Pending</span></td>
                        </tr>
                        <tr>
                            <td><a href="#demo-theme">Richard Miles</a></td>
                            <td><span class="badge badge-primary">Backend user</span></td>
                            <td><span class="badge badge-danger">Disabled</span></td>
                        </tr>
                    </tbody>
                </table>
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                    <li class="page-item active"><span class="page-link">1</span></li>
                    <li class="page-item"><a class="page-link" href="#demo-theme">2</a></li>
                    <li class="page-item"><a class="page-link" href="#demo-theme">3</a></li>
                    <li class="page-item"><a class="page-link" href="#demo-theme">&raquo;</a></li>
                </ul>
            @endcomponent
        </div>
        <div class="col-xl-6">
            @component('boilerplate::card', ['color' => 'primary', 'title' => 'Buttons, forms and menus'])
                <div class="mb-3">
                    <button type="button" class="btn btn-primary">Primary</button>
                    <button type="button" class="btn btn-default">Default</button>
                    <button type="button" class="btn btn-outline-secondary">Outline</button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Dropdown</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#demo-theme">Action</a>
                            <a class="dropdown-item" href="#demo-theme">Another action</a>
                        </div>
                    </div>
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#demo-theme-modal">Modal</button>
                </div>
                <div class="form-group">
                    <label for="demo-theme-input">Text input</label>
                    <input type="text" class="form-control" id="demo-theme-input" placeholder="Placeholder">
                </div>
                <div class="form-group">
                    <label for="demo-theme-select">Select</label>
                    <select class="custom-select" id="demo-theme-select">
                        <option>First option</option>
                        <option>Second option</option>
                    </select>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Amount" aria-label="Amount">
                    <div class="input-group-append">
                        <span class="input-group-text">.00</span>
                    </div>
                </div>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            @component('boilerplate::card', ['color' => 'success', 'title' => 'Success'])
                Meaningful colors keep their top border.
            @endcomponent
        </div>
        <div class="col-md-4">
            @component('boilerplate::card', ['color' => 'warning', 'title' => 'Warning'])
                Meaningful colors keep their top border.
            @endcomponent
        </div>
        <div class="col-md-4">
            @component('boilerplate::card', ['color' => 'danger', 'title' => 'Danger'])
                Meaningful colors keep their top border.
            @endcomponent
        </div>
    </div>
    <div class="modal fade" id="demo-theme-modal" tabindex="-1" aria-labelledby="demo-theme-modal-title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demo-theme-modal-title">Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">Modal content.</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
