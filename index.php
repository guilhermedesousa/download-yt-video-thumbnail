<?php

if (isset($_POST) && isset($_POST['download'])) {
    $img_url = $_POST['img_url'];
    $ch = curl_init($img_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $download = curl_exec($ch);
    curl_close($ch);

    header('Content-type: image/jpg');
    header('Content-Disposition: attachment; filename="thumbnail.jpg"');
    echo $download;
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Download YouTube Video Thumbnail</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
<form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
    <header>Download Thumbnail</header>
    <div class="url-input">
        <label class="title" for="url">Paste video url:</label>
        <div class="field">
            <input type="text" name="url" id="url" placeholder="https://www.youtube.com/watch?v=lqwdD2ivIbM" required>
            <input class="hidden-input" type="hidden" name="img_url">
            <div class="bottom-line"></div>
        </div>
    </div>
    <div class="preview-area">
        <img class="thumbnail" src="" alt="thumbnail">
        <i class="icon fas fa-cloud-download-alt"></i>
        <span>Paste video url to see preview</span>
    </div>
    <button type="submit" class="download-btn" name="download">Download Thumbnail</button>
</form>

<script>
    const urlField = document.querySelector('.field input'),
        previewArea = document.querySelector('.preview-area'),
        imgTag = previewArea.querySelector('.thumbnail'),
        hiddenInput = document.querySelector('.hidden-input')

    urlField.onkeyup = () => {
        let imgUrl = urlField.value // getting user entered value
        previewArea.classList.add('active')

        if (imgUrl.indexOf('https://www.youtube.com/watch?v=') !== -1) { // if entered value is yt video url
            let vidId = imgUrl.split('v=')[1].substring(0, 11)
            imgTag.src = `https://img.youtube.com/vi/${vidId}/maxresdefault.jpg`
        } else if (imgUrl.indexOf('https://youtu.be/') !== - 1) { // if video url is look like this
            let vidId = imgUrl.split('be/')[1].substring(0, 11)
            imgTag.src = `https://img.youtube.com/vi/${vidId}/maxresdefault.jpg`
        } else if (imgUrl.match(/\.(jpe?g|png|gif|bmp|webp)$/i)) { // if entered value is other image file url
            imgTag.src = imgUrl
        } else {
            imgTag.src = ''
            previewArea.classList.remove('active')
        }

        hiddenInput.value = imgTag.src
    }
</script>
</body>
</html>