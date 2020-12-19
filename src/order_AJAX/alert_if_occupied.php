<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Bootstrap CSS -->
    <!-- Modified Bootstrap CSS -->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" ></script> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" ></script>
    <!-- Our JavaScript -->

    <title>Page of Ondrej Richnak</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h1 class="text-center text-danger">Do you wont to destroy your open time slot?</h1>
                    <div class="row">
                        <div class="col">
                            <button class="btn  btn-danger  text-uppercase text-center" type="button" style="width: 100%;" onclick="answer('YES')" >YES</button>
                        </div>
                        <div class="col">
                            <button class="btn  btn-success  text-uppercase text-center" type="button" style="width: 100%;" onclick="answer('NO')" >NO</button>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


</body>


<script>
    function answer(param){
        if (param === 'Yes'){
            window.open('calendar.php',"_self");
        }else{
            window.open('calendar.php',"_self");
        }
    }

</script>