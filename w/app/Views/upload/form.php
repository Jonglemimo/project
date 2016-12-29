<?php
$this->layout('layout_upload', ['title' => 'Formulaire d\'envoi']);
$this->start('main_content');
?>
    <form id="fileupload" method="POST" enctype="multipart/form-data">

        <h4>Choix du poster de la vidéo</h4>

        <fieldset>
            <?php if(isset($errors['title'])) : ?>
                <p><?=$errors['title']?></p>
            <?php endif ?>

            <label>Titre</label>
            <input type="text" name="pictureTitle"><br>

            <?php if(isset(  $errors['file']['pictures'])) : ?>
                <p><?=   $errors['file']['pictures']?></p>
            <?php endif ?>
            
            <label>Image à upload</label>
            <input type="file" name="pictureUrl"><br>
        </fieldset>

        <fieldset>
            <h4>Choix de la vidéo</h4>
            
            <label>Titre</label>
            <input type="text" name="videoTitle">
        </fieldset>

        <?php if(isset($errors['description'])) : ?>
            <p><?=$errors['description']?></p>
        <?php endif ?>
        
        <label>Description</label>
        <textarea name="description" id="" cols="30" rows="10"></textarea><br>

            <!-- Redirect browsers with JavaScript disabled to the origin page -->
            <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
            <div class="row fileupload-buttonbar">
                <div class="col-lg-7">

                    <!-- The fileinput-button span is used to style the file input field as button -->
                    <span class="btn btn-success fileinput-button">
                        <i class="glyphicon glyphicon-plus"></i>
                        <span>Add files...</span>
                        <input type="file" name="files[]" multiple>
                    </span>

                    <button type="submit" class="btn btn-primary start">
                        <i class="glyphicon glyphicon-upload"></i>
                        <span>Start upload</span>
                    </button>

                    <button type="reset" class="btn btn-warning cancel">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <span>Cancel upload</span>
                    </button>

                    <button type="button" class="btn btn-danger delete">
                        <i class="glyphicon glyphicon-trash"></i>
                        <span>Delete</span>
                    </button>

                    <input type="checkbox" class="toggle">
                    <!-- The global file processing state -->
                    <span class="fileupload-process"></span>
                </div>

                <!-- The global progress state -->
                <div class="col-lg-5 fileupload-progress fade">
                    <!-- The global progress bar -->
                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                    </div>
                    <!-- The extended global progress state -->
                    <div class="progress-extended">&nbsp;</div>
                </div>

            </div>
            <!-- The table listing the files available for upload/download -->
            <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
            <button class="btn btn-default" type="submit" name="addMovie">Envoyer</button>
        </form>

<?php if(isset( $sucess['status']['error'])) : ?>
    <p><?= $sucess['status']['error']?></p>
<?php endif ?>

<?php if(isset( $sucess['status']['sucess'])) : ?>
    <p><?= $sucess['status']['sucess']?></p>
<?php endif ?>

<?php $this->stop('main_content'); ?>
<?php $this->start('script')?>

<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="<?=$this->assetUrl('vendors/jQuery-File-Upload/js/vendor/jquery.ui.widget.js')?>"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<!-- blueimp Gallery script -->
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?=$this->assetUrl('vendors/jQuery-File-Upload/js/jquery.iframe-transport.js')?>"></script>
<!-- The basic File Upload plugin -->
<script src="<?=$this->assetUrl('vendors/jQuery-File-Upload/js/jquery.fileupload.js')?>"></script>
<!-- The File Upload processing plugin -->
<script src="<?=$this->assetUrl('vendors/jQuery-File-Upload/js/jquery.fileupload-process.js')?>"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?=$this->assetUrl('vendors/jQuery-File-Upload/js/jquery.fileupload-image.js')?>"></script>
<!-- The File Upload audio preview plugin -->
<script src="<?=$this->assetUrl('vendors/jQuery-File-Upload/js/jquery.fileupload-audio.js')?>"></script>
<!-- The File Upload video preview plugin -->
<script src="<?=$this->assetUrl('vendors/jQuery-File-Upload/js/jquery.fileupload-video.js')?>"></script>
<!-- The File Upload validation plugin -->
<script src="<?=$this->assetUrl('vendors/jQuery-File-Upload/js/jquery.fileupload-validate.js')?>"></script>
<!-- The File Upload user interface plugin -->
<script src="<?=$this->assetUrl('vendors/jQuery-File-Upload/js/jquery.fileupload-ui.js')?>"></script>
<!-- The main application script -->
<script>

    $(function () {
        $('#fileupload').fileupload({
            dataType: 'json',
            add: function (e, data) {
                data.context = $('<button/>').text('Upload')
                    .appendTo(document.body)
                    .click(function () {
                        data.context = $('<p/>').text('Uploading...').replaceAll($(this));
                        data.submit();
                    });
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .bar').css(
                    'width',
                    progress + '%'
                );
            },
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('<p/>').text(file.name).appendTo(document.body);
                });
                data.context.text('Upload finished.');
            }
        });
    });
</script>

<?php $this->stop('script')?>
