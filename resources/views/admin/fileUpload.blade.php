<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload File</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
</head>
<body>
<div class="container mt-5" style="max-width: 900px">
    <div class="p-4 text-center mb-2">
        <h2 class="text-black m-0">Upload File</h2>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="bg bg-success success__msg bg-light" style="display: none; color: green;" role="alert">
                Uploaded File successfully.
            </div>
        </div>
    </div>
    <div class="card bg-transparent border rounded-3 mb-5 p-5">
        <form id="UploadfileID" method="POST" action="{{ route('fileUpload.upload') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <input name="file" type="file" class="form-control">
            </div>
            <div class="form-group">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-dark" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                </div>
            </div>
            <div class="d-grid mt-4">
                <input type="submit" value="Upload File" class="btn btn-light">
            </div>
        </form>
    </div>
</div>
<script>
    $(function () {
        $(document).ready(function () {
            var message = $('.success__msg');
            var form = $('#UploadfileID');

            form.ajaxForm({
                beforeSend: function () {
                    // progress bar reset
                    var percentVal = '0%';
                    $('.progress .progress-bar')
                        .width(percentVal)
                        .attr('aria-valuenow', 0)
                        .text(percentVal);
                },
                uploadProgress: function (event, position, total, percentComplete) {
                    var percentVal = percentComplete + '%';
                    $('.progress .progress-bar')
                        .width(percentVal)
                        .attr('aria-valuenow', percentComplete)
                        .text(percentVal);
                },
                complete: function (xhr) {
                    console.log('File has uploaded');
                    message.fadeIn().removeClass('alert-danger').addClass('alert-success');
                    message.text("File Uploaded successfully.");

                    setTimeout(function () {
                        message.fadeOut();
                    }, 2000);

                    // formni tozalash
                    form[0].reset();
                    $('.progress .progress-bar')
                        .width('0%')
                        .attr('aria-valuenow', 0)
                        .text('0%');
                }
            });
        });
    });
</script>

</body>
</html>
