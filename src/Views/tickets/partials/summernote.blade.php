@if($editor_enabled)

@if($codemirror_enabled)
    <script src="{{asset('vendor/panichd/js/codemirror/codemirror-' . PanicHD\PanicHD\Helpers\Cdn::CodeMirror . '.min.js')}}"></script>
    <script src="{{asset('vendor/panichd/js/codemirror/mode/xml-' . PanicHD\PanicHD\Helpers\Cdn::CodeMirror . '.min.js')}}"></script>
@endif

<script src="{{ asset('vendor/panichd/js/summernote/summernote-bs4.min.js') }}"></script>
@if($editor_locale)
    <script src="{{ asset('vendor/panichd/js/summernote/lang/summernote-'.$editor_locale.'.js') }}"></script>
@endif

<script>
    var summernote_options = "";

    $(function() {

        summernote_options = $.extend(true, {lang: '{{$editor_locale}}' {!! $codemirror_enabled ? ", codemirror: {theme: '{$codemirror_theme}', mode: 'text/html', htmlMode: true, lineWrapping: true}" : ''  !!} } , {!! $editor_options !!});

        // Usage within HTML Body
        $("textarea.summernote-editor").summernote(summernote_options);

        $("label[for=content]").click(function () {
            $("#content").summernote("focus");
        });
    });
</script>
@endif