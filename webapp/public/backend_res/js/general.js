function loadTinyMce(cl){
    $('.'+cl).tinymce({
        script_url: '/backend_res/js/tinymce/tinymce.min.js',
        width: "100%",
        height: 200,
        theme_advanced_fonts: "Arial=arial;",
        //theme_advanced_font_sizes: "12px, 14px, 18px, 24px, 36px",
        fontsize_formats: "8pt 9pt 10pt 11pt 12pt 26pt 36pt",
        toolbar: "insertfile undo redo | styleselect | fontselect | fontsizeselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages | forecolor backcolor,media | table | fullscreen code",

        theme: "modern",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars",
            "insertdatetime media nonbreaking save contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern imagetools responsivefilemanager fullscreen",
            "code media table"
        ],
        extended_valid_elements: "audio[id|class|src|type|controls]",
        //extended_valid_elements: "audio[id|class|src|type|controls],script[language|type|src],style[type]",
        audio_template_callback: function (data) {
            return '<audio controls>' + '\n<source src="' + data.source1 + '"' + (data.source1mime ? ' type="' + data.source1mime + '"' : '') + ' />\n' + '</audio>';
        },
        menubar: "insert, table",
        media_live_embeds: true,
        media_alt_source: false,
        external_filemanager_path: "/backend_res/plugin/filemanager/",
        relative_urls: false,
        remove_script_host: false,
        filemanager_title:"Responsive Filemanager" ,
        external_plugins: { "filemanager" : "/backend_res/plugin/filemanager/plugin.min.js"}
    });
}