
<?php
include('head.php');
include('incs/options.php');
$submittedref = $_POST['txnref'];
$submittedamt = $_SESSION['amt4hash'];


?>


<body>
<?php
$json = dquery($submittedamt,$submittedref);
?>
<div class="container">

    <!-- row 3: article/aside -->
    <div class="row" style="text-align: center">
        <div class="col-md-offset-4 col-md-4 col-md-offset-4">
            <h2>TRANSACTION STATUS (Query Response)</h2>
            <div class="thumbnail">
                <div class="caption">
                    <h4><span class="glyphicon glyphicon-pushpin"></span> <?php echo ($json['ResponseCode']); ?> </h4>
                    <p><?php echo ($json['ResponseDescription']);?></p>
                    <P>RAW RESPONSE<br /><?php print_r($json) ;?></P>
                </div>
            </div>

            <?php

            if ($json['ResponseCode'] == "00"){?>
            <img src="css/thankyou.jpg" alt="ok" />
            <!-- nested row 3a: callouts -->
            <div class="row">
                    <div class="thumbnail">
                        <div class="caption">
                            <h4><span class="glyphicon glyphicon-pushpin"></span>
                            <?php echo ($json['ResponseCode']); ?> </h4>
                            <p><?php echo ($json['ResponseDescription']);?></p>

                    </div>
                </div>


                <?php } else {?>
                    <img src="css/notok.jpg" alt="not ok" />
                <?php } ?>

        </div>

    </div>

</div> <!-- end container -->

<!-- javascript -->
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
    $('a.btn-info').tooltip()
</script>
</body>
</html>