<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Bootbox</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-body">
        <p><button class="btn btn-primary" onclick="bootbox.alert('Ceci est un exemple de bootbox')">bootbox.alert</button></p>
        <pre class="prettyprint">bootbox.alert('Ceci est un exemple de bootbox')</pre>

        <p><button class="btn btn-primary" onclick="bootbox.confirm('Confirmez vous l\'action ?', function(result){ console.log('Résultat: ' + result); });">bootbox.confirm</button></p>
        <pre class="prettyprint">bootbox.confirm("Confirmez vous l'action ?", function(result){ console.log('Résultat: ' + result); });</pre>

        <p><button class="btn btn-primary" onclick="bootbox.prompt('Entrez une valeur', function(result){ console.log(result); });">bootbox.prompt</button></p>
        <pre class="prettyprint">bootbox.prompt("Entrez une valeur", function(result){ console.log(result); });</pre>
    </div>
</div>