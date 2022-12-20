<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdn.staticfile.org/bootstrap/5.2.3/css/bootstrap.min.css" />
<script src="https://cdn.staticfile.org/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
<!-- <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script> -->
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
</style>
<script>
    window.onload = function() {
        document.body.ondragstart = () => {
            return false
        }
    }
</script>