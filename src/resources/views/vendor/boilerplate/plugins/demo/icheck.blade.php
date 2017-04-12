@include('boilerplate::load.icheck')

<div class="box box-success">
    <div class="box-header">
        <h3 class="box-title">iCheck - Checkbox &amp; Radio</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-body">
        Usage :
        <pre>
&commat;include('boilerplate::load.icheck')
&ltinput type="checkbox" class="icheck">
</pre>
        <p>
            Skins : minimal, square, flat<br />
            Colors : black, red, green, blue, aero, grey, orange, yellow, pink, purple
        </p>
        <table class="table">
            <thead>
            <tr>
                <th>CSS classes</th>
                <th>Results</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        icheck (= icheck square blue)
                    </td>
                    <td>
                        <input type="checkbox" class="icheck" checked>
                        <input type="checkbox" class="icheck">
                        <input type="checkbox" class="icheck" disabled>
                        <span class="mrm">&nbsp;</span>
                        <input type="radio" name="r1" class="icheck" checked>
                        <input type="radio" name="r1" class="icheck">
                        <input type="radio" name="r1" class="icheck" disabled>
                    </td>
                </tr>
                <tr>
                    <td>
                        icheck minimal red
                    </td>
                    <td>
                        <input type="checkbox" class="icheck minimal red" checked>
                        <input type="checkbox" class="icheck minimal red">
                        <input type="checkbox" class="icheck minimal red" disabled>
                        <span class="mrm">&nbsp;</span>
                        <input type="radio" name="r2" class="icheck minimal red" checked>
                        <input type="radio" name="r2" class="icheck minimal red">
                        <input type="radio" name="r2" class="icheck minimal red" disabled>
                    </td>
                </tr>
                <tr>
                    <td>
                        icheck flat green
                    </td>
                    <td>
                        <input type="checkbox" class="icheck flat green" checked>
                        <input type="checkbox" class="icheck flat green">
                        <input type="checkbox" class="icheck flat green" disabled>
                        <span class="mrm">&nbsp;</span>
                        <input type="radio" name="r3" class="icheck flat green" checked>
                        <input type="radio" name="r3" class="icheck flat green">
                        <input type="radio" name="r3" class="icheck flat green" disabled>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
</div>