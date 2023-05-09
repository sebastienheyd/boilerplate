<?php

namespace Sebastienheyd\Boilerplate\Tests\Components;

class TinymceTest extends TestComponent
{
    public function testTinymceComponentNoName()
    {
        $expected = <<<'HTML'
<code>&lt;x-boilerplate::tinymce>The name attribute has not been set</code>
HTML;

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::tinymce id="test" />');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::tinymce', ['id' => 'test'])@endcomponent()");
        $view->assertSee($expected, false);
    }

    public function testTinymceComponent()
    {
        $expected = <<<'HTML'
<div class="form-group test" id="test">
    <label for="test">test</label>
    <textarea id="test" name="test" style="visibility:hidden"></textarea>
</div>
<script>loadScript("",()=>{tinymce.defaultSettings={plugins:"autoresize fullscreen codemirror link lists table media image imagetools paste customalign",toolbar:"undo redo | styleselect | bold italic underline | customalignleft aligncenter customalignright | gpt link media image | bullist numlist | table | code fullscreen",contextmenu:"link image imagetools table spellchecker bold italic underline",toolbar_drawer:"sliding",toolbar_sticky_offset:$('nav.main-header').outerHeight(),codemirror:{config:{theme:'storm'}},menubar:!1,removed_menuitems:'newdocument',remove_linebreaks:!1,forced_root_block:!1,force_p_newlines:!0,relative_urls:!1,verify_html:!1,branding:!1,statusbar:!1,browser_spellcheck:!0,encoding:'UTF-8',image_uploadtab:!1,deprecation_warnings:!1,setup:(editor)=>{editor.ui.registry.addIcon('gpt','<svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 671.194 680.2487"><path d="M626.9464,278.4037a169.4492,169.4492,0,0,0-14.5642-139.187A171.3828,171.3828,0,0,0,427.7883,56.9841,169.45,169.45,0,0,0,299.9746.0034,171.3985,171.3985,0,0,0,136.4751,118.6719,169.5077,169.5077,0,0,0,23.1574,200.8775,171.41,171.41,0,0,0,44.2385,401.845,169.4564,169.4564,0,0,0,58.8021,541.0325a171.4,171.4,0,0,0,184.5945,82.2318A169.4474,169.4474,0,0,0,371.21,680.2454,171.4,171.4,0,0,0,534.7642,561.51a169.504,169.504,0,0,0,113.3175-82.2063,171.4116,171.4116,0,0,0-21.1353-200.9ZM371.2647,635.7758a127.1077,127.1077,0,0,1-81.6027-29.5024c1.0323-.5629,2.8435-1.556,4.0237-2.2788L429.13,525.7575a22.0226,22.0226,0,0,0,11.1306-19.27V315.5368l57.25,33.0567a2.0332,2.0332,0,0,1,1.1122,1.568V508.2972A127.64,127.64,0,0,1,371.2647,635.7758ZM97.3705,518.7985a127.0536,127.0536,0,0,1-15.2074-85.4256c1.0057.6037,2.7624,1.6768,4.0231,2.4012L221.63,514.01a22.04,22.04,0,0,0,22.2492,0L409.243,418.5281v66.1134a2.0529,2.0529,0,0,1-.818,1.7568l-136.92,79.0534a127.6145,127.6145,0,0,1-174.134-46.6532ZM61.7391,223.1114a127.0146,127.0146,0,0,1,66.3545-55.8944c0,1.1667-.067,3.2329-.067,4.6665V328.3561a22.0038,22.0038,0,0,0,11.1173,19.2578l165.3629,95.4695-57.2481,33.055a2.0549,2.0549,0,0,1-1.9319.1752l-136.933-79.1215A127.6139,127.6139,0,0,1,61.7391,223.1114ZM532.0959,332.5668,366.7308,237.0854l57.25-33.0431a2.0455,2.0455,0,0,1,1.93-.1735l136.934,79.0535a127.5047,127.5047,0,0,1-19.7,230.055V351.8247a21.9961,21.9961,0,0,0-11.0489-19.2579Zm56.9793-85.7589c-1.0051-.6174-2.7618-1.6769-4.0219-2.4L449.6072,166.1712a22.07,22.07,0,0,0-22.2475,0L261.9963,261.6543V195.5409a2.0529,2.0529,0,0,1,.818-1.7567l136.9205-78.988a127.4923,127.4923,0,0,1,189.34,132.0117ZM230.8716,364.6456,173.6082,331.589a2.0321,2.0321,0,0,1-1.1122-1.57V171.8835A127.4926,127.4926,0,0,1,381.5636,73.9884c-1.0322.5633-2.83,1.5558-4.0236,2.28L242.0957,154.5044a22.0025,22.0025,0,0,0-11.1306,19.2566Zm31.0975-67.0521L335.62,255.0559l73.6488,42.51v85.0481L335.62,425.1266l-73.6506-42.5122Z"/></svg>');editor.ui.registry.addButton("gpt",{icon:"gpt",tooltip:"Generate text with GPT",enabled:!0,onAction:(_)=>{tinymce.activeEditor.windowManager.openUrl({url:'/admin/gpt',title:"Generate with GPT",width:Math.round(window.innerWidth*0.5),height:520,onMessage:function(instance,data){if(data.mceAction==='confirmGPTContent'){bootbox.confirm({title:"Generated text",message:data.content,size:'xl',callback:function(res){if(res){editor.insertContent(data.content);tinymce.activeEditor.windowManager.close()}}})}}})},})},paste_preprocess:function(plugin,args){args.content=args.content.replace(/<(\/)*(\\?xml:|meta|link|span|font|del|ins|st1:|[ovwxp]:)((.|\s)*?)>/gi,'');args.content=args.content.replace(/\s(class|style|type|start)=("(.*?)"|(\w*))/gi,'');args.content=args.content.replace(/<(p|a|div|span|strike|strong|i|u)[^>]*?>(\s|&nbsp;|<br\/>|\r|\n)*?<\/(p|a|div|span|strike|strong|i|u)>/gi,'')},skin:window.matchMedia("(prefers-color-scheme: dark)")?"boilerplate-dark":'oxide',content_css:window.matchMedia("(prefers-color-scheme: dark)")?"boilerplate-dark":'',};setInterval(()=>{if(tinymce.editors.length>0){$(tinymce.editors).each((i,e)=>{if($('#'+e.id).length===0){tinymce.get(e.id).remove()}})}})});</script><script>whenAssetIsLoaded('',()=>{window.MCE_test=tinymce.init({selector:'#test',toolbar_sticky:!1,})});</script>
HTML;

        if ($this->minLaravelVersion('7.0')) {
            $view = $this->blade('<x-boilerplate::tinymce id="test" name="test" group-id="test" group-class="test" label="test"/>@stack("js")');
            $view->assertSee($expected, false);
        }

        $view = $this->blade("@component('boilerplate::tinymce', ['id' => 'test', 'name' => 'test', 'group-id' => 'test', 'group-class' => 'test', 'label' => 'test'])@endcomponent()@stack('js')");
        $view->assertSee($expected, false);
    }
}
