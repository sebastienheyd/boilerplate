<div class="box box-info">
    <div class="box-header">
        <h3 class="box-title">Bootbox</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-body">
        <p><button class="btn btn-primary" onclick="bootbox.alert('Example')">bootbox.alert</button></p>
        <pre class="prettyprint">bootbox.alert('Example')</pre>

        <p><button class="btn btn-primary" onclick="bootbox.confirm('OK', function(result){ console.log('Result: ' + result); });">bootbox.confirm</button></p>
        <pre class="prettyprint">bootbox.confirm("OK ?", function(result){ console.log('Result: ' + result); });</pre>

        <p><button class="btn btn-primary" onclick="bootbox.prompt('Value', function(result){ console.log(result); });">bootbox.prompt</button></p>
        <pre class="prettyprint">bootbox.prompt("Value", function(result){ console.log(result); });</pre>
    </div>
</div>