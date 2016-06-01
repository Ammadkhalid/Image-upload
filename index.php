<?php
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(isset($_FILES['file'])) {
        $file = $_FILES['file'];
        $name = $file['name'];
        $size = $file['size'];
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

        if($ext == 'jpeg' | $ext == 'jpg' | $ext == 'png') {
            if($size <= 5242880) {

                $chk_image = getimagesize($file['tmp_name']);
                if($chk_image) {

                    $move = move_uploaded_file($file['tmp_name'], 'uploads/'.$name);
                    if($move) {

                        $chk = rename('uploads/'.$name, 'uploads/'.md5(rand(0, 100)).'.'.$ext);
                        if($chk) {
                            echo 'Image Success Fully Uploaded!';
                        }
                    } else {
                        echo "ERROR!";
                    }
                } else {
                    echo "Invalid image!";
                }
            } else {
                echo "File size was too large.";
            }
        } else {
            echo "File was not image file.";
        }

    }
} else { ?>
<html>
    <head>
        <title>Secure image upload</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
        <script>
        $(document).ready(function () {

            file = $("#file");

            file.on("change", function () {
                filename = file.val().split("\\").pop();

                ext = filename.split(".").pop().toLowerCase();
                if(ext == "jpeg" || ext == "jpg" || ext == "gif" || ext == "png") {

                    var formdata = new FormData();

                    formdata.append('file', $("#file")[0].files[0]);
                    $.ajax({
                        url: "<?php echo $_SERVER['PHP_SELF']; ?>",
                        type: "POST",
                        data: formdata,
                        contentType: false,
                        processData: false,
                        success: function (chk) {

                            $(".show").html(chk);
                        
                        }
                    })
                } else {
                    $(".show").html("Please Select Image file!")
                }
            });
        })
        </script>
    </head>
    <body>
       <form action="" enctype="multipart/form-data" method="post" id='form'>
           <input type="file" value="Upload file" name="file" id="file"><br />
           <button type="submit" id='button'>Upload</button>
       </form><br />
       <div class="show"></div>
    </body>
</html>
<?php
if(isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $name = $file['name'];
    $size = $file['size'];
    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

    if($ext == 'jpeg' | $ext == 'jpg' | $ext == 'png') {
        if($size <= 5242880) {

            $chk_image = getimagesize($file['tmp_name']);
            if($chk_image) {

                $move = move_uploaded_file($file['tmp_name'], 'uploads/'.$name);
                if($move) {

                    $chk = rename('uploads/'.$name, 'uploads/'.md5(rand(0, 100)).'.'.$ext);
                    if($chk) {
                        echo 'Image Success Fully Uploaded!';
                    }
                } else {
                    echo "ERROR!";
                }
            } else {
                echo "Invalid image!";
            }
        } else {
            echo "File size was too large.";
        }
    } else {
        echo "File was not image file.";
    }

}
}
?>
