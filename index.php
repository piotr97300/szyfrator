<html>
<head>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

</head>
<body>

<div class="jumbotron">
<form class="form-horizontal" role="form" action="process_with_xor.php" target="_blank" method="post"
      enctype="multipart/form-data">
    <div class="form-group">
        <label for="file" class="col-sm-2 control-label">File</label>

        <div class="col-sm-10">
            <input type="file" class="form-control" id="file" name="file">
        </div>
    </div>
    <div class="form-group">
        <label for="key" class="col-sm-2 control-label">Key</label>

        <div class="col-sm-10">
            <textarea class="form-control" id="key" name="key"></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <div class="btn-group">
                <input class="btn btn-primary" type="submit" name="encrypt" id="encrypt" value="Encrypt"/>
                <input class="btn btn-primary" type="submit" name="decrypt" id="decrypt" value="Decrypt"/>
            </div>
        </div>
    </div>
</form>
</div>
</body>
</html>
