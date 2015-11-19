<style type="text/css">
    .CodeMirror{
        height: 95% !important;
        border: 2px solid #cccccc;
        border-radius: 5px;
    }
    #button{
    border: none !important;
    height: 30px;
    width: 100px;
    font-size: 14px;
    float: right;
    margin: 10px 20px 0 0;
    }
</style>
<div class="heading">
    <h1>{lang('Mobile setting manager')}</h1>
</div>
<div class="content">
    <!-- Create a simple CodeMirror instance -->
    <link rel="stylesheet" href="{base_url()}static/default/js/CodeMirror/lib/codemirror.css">
    <script src="{base_url()}static/default/js/CodeMirror/lib/codemirror.js"></script>
    <script src="{base_url()}static/default/js/CodeMirror/mode/css/css.js"></script>
    <form action="" method="POST" style="height: 500px;">
        <textarea id="code" name="code">{$content_css}</textarea>
        <input type="submit" value="Update" class="button" id="button">
    </form>
    <script>
        var editor = CodeMirror.fromTextArea(document.getElementById("code"), {});
    </script>
</div>