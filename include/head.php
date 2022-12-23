<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdn.staticfile.org/bootstrap/5.2.3/css/bootstrap.min.css" />
<script src="https://cdn.staticfile.org/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
<link rel="apple-touch-icon" sizes="180x180" href="icon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="icon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="icon/favicon-16x16.png">
<link rel="manifest" href="./site.webmanifest">
<style>
    .limit-line-4 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
    }

    .text-justify {
        text-align: justify;
    }

    *::selection {
        background: rgba(255, 71, 71, 0.3);
        color: inherit;
    }

    *::-moz-selection {
        background: rgba(255, 71, 71, 0.3);
        color: inherit;
    }

    *::-webkit-selection {
        background: rgba(255, 71, 71, 0.3);
        color: inherit;
    }

    a {
        text-decoration: none;
    }
</style>
<script>
    window.onload = function() {
        document.body.ondragstart = () => {
            return false
        }
    }
</script>