<?php

namespace Sebastienheyd\Boilerplate\Tests\Components;

class TinymceTest extends TestComponent
{
    public function testTinymceComponentNoName()
    {
        $expected = <<<'HTML'
<code>&lt;x-boilerplate::tinymce>The name attribute has not been set</code>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::tinymce id="test" />');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::tinymce', ['id' => 'test'])@endcomponent()");
        $this->assertEquals($expected, $view);
    }

    public function testTinymceComponent()
    {
        $expected = <<<'HTML'
<div class="form-group test" id="test">
    <label for="test">test</label>
    <textarea id="test" name="test" style="visibility:hidden"></textarea>
</div>
<script>loadScript("",()=>{tinymce.defaultSettings={plugins:"autoresize fullscreen codemirror link lists table media image imagetools paste customalign",toolbar:"undo redo | styleselect | bold italic underline | customalignleft aligncenter customalignright | link media image | bullist numlist | table | code fullscreen",contextmenu:"link image imagetools table spellchecker bold italic underline",toolbar_drawer:"sliding",toolbar_sticky_offset:$('nav.main-header').outerHeight(),codemirror:{config:{theme:'storm'}},menubar:!1,removed_menuitems:'newdocument',remove_linebreaks:!1,forced_root_block:!1,force_p_newlines:!0,relative_urls:!1,verify_html:!1,branding:!1,statusbar:!1,browser_spellcheck:!0,encoding:'UTF-8',image_uploadtab:!1,deprecation_warnings:!1,paste_preprocess:function(plugin,args){args.content=args.content.replace(/<(\/)*(\\?xml:|meta|link|span|font|del|ins|st1:|[ovwxp]:)((.|\s)*?)>/gi,'');args.content=args.content.replace(/\s(class|style|type|start)=("(.*?)"|(\w*))/gi,'');args.content=args.content.replace(/<(p|a|div|span|strike|strong|i|u)[^>]*?>(\s|&nbsp;|<br\/>|\r|\n)*?<\/(p|a|div|span|strike|strong|i|u)>/gi,'')},skin:"oxide",};setInterval(()=>{if(tinymce.editors.length>0){$(tinymce.editors).each((i,e)=>{if($('#'+e.id).length===0){tinymce.get(e.id).remove()}})}})});</script><script>whenAssetIsLoaded('',()=>{window.MCE_test=tinymce.init({selector:'#test',toolbar_sticky:!1,skin:"oxide",content_css:null,})});</script>
HTML;

        if ($this->isLaravelEqualOrGreaterThan7) {
            $view = $this->blade('<x-boilerplate::tinymce id="test" name="test" group-id="test" group-class="test" label="test"/>@stack("js")');
            $this->assertEquals($expected, $view);
        }

        $view = $this->blade("@component('boilerplate::tinymce', ['id' => 'test', 'name' => 'test', 'group-id' => 'test', 'group-class' => 'test', 'label' => 'test'])@endcomponent()@stack('js')");
        $this->assertEquals($expected, $view);
    }
}
