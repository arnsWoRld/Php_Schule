<!DOCTYPE html>
<html>
    <head>
        <script src="./tinymce/tinymce.min.js"></script>
        <script type="text/javascript">
            tinymce.init({
                selector: '#textareatiny',
                language: 'de',

                plugins: [
                    "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern codesample"
                ],
                toolbar1: "bold italic underline | alignleft aligncenter alignright alignjustify | codesample | print | removeformat | subscript superscript charmap | spellchecker pagebreak \n\
                          styleselect formatselect fontselect fontsizeselect | \n\
                          searchreplace | bullist numlist | \n\
                          outdent indent blockquote | undo redo | \n\
                          link unlink image code | forecolor backcolor | table ",
                menubar: true,
                toolbar_items_size: 'small',
                style_formats: [
                    {title: 'Bold text', inline: 'b'},
                    {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                    {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                    {title: 'Example 1', inline: 'span', classes: 'example1'},
                    {title: 'Example 2', inline: 'span', classes: 'example2'},
                    {title: 'Table styles'},
                    {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                ],
                // without images_upload_url set, Upload tab won't show up
                images_upload_url: 'upload.php',
                // override default upload handler to simulate successful upload
                images_upload_handler: function (blobInfo, success, failure) {
                    var xhr, formData;

                    xhr = new XMLHttpRequest();
                    xhr.withCredentials = false;
                    xhr.open('POST', 'upload.php');

                    xhr.onload = function () {
                        var json;

                        if (xhr.status != 200) {
                            failure('HTTP Error: ' + xhr.status);
                            return;
                        }

                        json = JSON.parse(xhr.responseText);

                        if (!json || typeof json.location != 'string') {
                            failure('Invalid JSON: ' + xhr.responseText);
                            return;
                        }

                        success(json.location);
                    };

                    formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());

                    xhr.send(formData);
                },

            });
            tinymce.init({
                selector: '#tinyzwei',

            });
        </script>
    </head>

    <body>
        <h1>TinyMCE Quick Start Guide</h1>
        <form method="post">
            <textarea id="textareatiny">Hello, World!</textarea>
            <textarea id="tinyzwei">Hello, World!</textarea>
        </form>
    </body>
</html>
