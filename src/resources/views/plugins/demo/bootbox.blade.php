@component('boilerplate::card', ['color' => 'pink', 'title' => 'Bootbox'])
    <p><button class="btn btn-primary" onclick="bootbox.alert('Example')">bootbox.alert</button></p>
    <pre class="prettyprint">bootbox.alert('Example')</pre>
    <p><button class="btn btn-primary" onclick="bootbox.confirm('OK', function(result){ console.log('Result: ' + result); });">bootbox.confirm</button></p>
    <pre class="prettyprint">bootbox.confirm("OK ?", function(result){ console.log('Result: ' + result); });</pre>
    <p><button class="btn btn-primary" onclick="bootbox.prompt('Value', function(result){ console.log(result); });">bootbox.prompt</button></p>
    <pre class="prettyprint">bootbox.prompt("Value", function(result){ console.log(result); });</pre>
    <p><button class="btn btn-primary" onclick="bootbox.dialog({ message: '<h1>HTML message</h1><p>Hello there !</p>'})">bootbox.dialog</button></p>
    <pre class="prettyprint">bootbox.dialog({ message: '&lt;h1>HTML message&lt;/h1>&lt;p>Hello there !&lt;/p>' });</pre>
    @slot('footer')
        <div class="small text-muted text-right">
            <a href="http://bootboxjs.com/documentation.html" target="_blank">bootbox</a>
        </div>
    @endslot
@endcomponent
