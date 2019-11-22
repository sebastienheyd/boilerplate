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

        <p><button class="btn btn-primary" onclick="bootbox.dialog({ message: '<h1>HTML message</h1><p>Hello there !</p>'})">bootbox.dialog</button></p>
        <pre class="prettyprint">bootbox.dialog({ message: '&lt;h1>HTML message&lt;/h1>&lt;p>Hello there !&lt;/p>' });</pre>
    </div>
    <div class="box-footer small text-muted text-right">
        <a href="http://bootboxjs.com/documentation.html" target="_blank">bootbox</a>
    </div>
</div>
