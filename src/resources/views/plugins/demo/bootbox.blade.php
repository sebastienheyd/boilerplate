<div class="card card-purple card-outline">
    <div class="card-header border-bottom-0">
        <h3 class="card-title">Bootbox</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body pt-0">
        <p><button class="btn btn-primary" onclick="bootbox.alert('Example')">bootbox.alert</button></p>
        <pre class="prettyprint">bootbox.alert('Example')</pre>

        <p><button class="btn btn-primary" onclick="bootbox.confirm('OK', function(result){ console.log('Result: ' + result); });">bootbox.confirm</button></p>
        <pre class="prettyprint">bootbox.confirm("OK ?", function(result){ console.log('Result: ' + result); });</pre>

        <p><button class="btn btn-primary" onclick="bootbox.prompt('Value', function(result){ console.log(result); });">bootbox.prompt</button></p>
        <pre class="prettyprint">bootbox.prompt("Value", function(result){ console.log(result); });</pre>

        <p><button class="btn btn-primary" onclick="bootbox.dialog({ message: '<h1>HTML message</h1><p>Hello there !</p>'})">bootbox.dialog</button></p>
        <pre class="prettyprint">bootbox.dialog({ message: '&lt;h1>HTML message&lt;/h1>&lt;p>Hello there !&lt;/p>' });</pre>
    </div>
    <div class="card-footer small text-muted text-right">
        <a href="http://bootboxjs.com/documentation.html" target="_blank">bootbox</a>
    </div>
</div>
