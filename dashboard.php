<?php

 //include_once "server/config/config.php";
 include_once "server/fetchLoginData.php";
 session_start(); 
?>
<!DOCTYPE html>
<html>
    <head>
        <title>CSS</title>
        <meta charset="utf-8">
        <link href="CSS/style.css" rel='stylesheet' type='text/css' />
        <link href="CSS/bootstrap.min.css" rel='stylesheet' type='text/css' />
            <link rel="shortcut icon" href="images/css_logo.png" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:600italic,400,300,600,700' rel='stylesheet' type='text/css'>

    </head>
    <body>
        <div class="container">
            <h2 style="text-align: center">Custom Software Solution</h2>
            <br>
            <div class="btn-group btn-group-justified">

                <a href="#" class="btn btn-primary">Dashboard</a>
                <a href="#" class="btn btn-primary">PHP</a>
                <a href="#" class="btn btn-primary">Bootstrap</a>
                <a href="#" class="btn btn-primary">WordPress</a>
            </div>
        </div>
        <div class="container">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Login Time</th>
                        <th>Logout Time</th>
                        <th>Duration</th>
                        <th>Remark</th>
                        <th>Logout</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($response) && $response->num_rows > 0): $i = 1; ?>
                        <?php while($row = $response->fetch_assoc()):?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <?php 
                                        $d1= "";
                                        $dateObj = "";
                                        $d2= "";
                                        $dateObj2 = "";
                                        $fullDate = "";
                                        $loginTime = "";
                                        $logoutTime = "";
                                        $duration = "";
                                        $timestamp = "";
                                        if(isset($row['loginTime']) && !empty($row['loginTime']))
                                        {
                                            $d1 = date_parse_from_format("Y-m-d H:i:s", $row['loginTime']);

                                            $dateObj   = DateTime::createFromFormat('!m', $d1['month']);
                                            $monthName1 = $dateObj->format('F');
                                            $fullDate = $d1['day'].' '.$monthName1.' '.$d1['year'];
                                            $loginTime = $d1['hour'].':'.$d1['minute'].':'.$d1['second'];
                                            $timeI = strtotime($d1['hour'].':'.$d1['minute'])+(60*60*9);
                                            $timestamp = date('H:i',$timeI);

                                        }
                                        else
                                        {
                                            $loginTime = "";
                                            $fullDate = "";
                                        }
                                        if(isset($row['logoutTime']) && !empty($row['logoutTime']))
                                        {
                                            $d2 = date_parse_from_format("Y-m-d H:i:s", $row['logoutTime']);
                                            $dateObj2   = DateTime::createFromFormat('!m', $d2['month']);
                                            $monthName2 = $dateObj2->format('F');
                                            $logoutTime = $d2['hour'].':'.$d2['minute'].':'.$d2['second'];
                                        }  
                                        else
                                        {
                                            $logoutTime = "";
                                        } 
                                ?>
                                <td><?php echo $fullDate; ?></td>
                                <td><?php echo $loginTime; ?></td>
                                <td><?php echo $logoutTime; ?></td>
                                <td></td>
                                <td><?php if(isset($row['userRemark']) && !empty($row['userRemark'])) echo $row['userRemark']; else echo '';?></td>
                                <td>
                                    <?php if($row['loginTime'] <= date('Y-m-d').' 23:59:59' && $d1['day'] == date('d')):?>
                                        <input type="button" value="Logout" id="<?php echo $row['id']; ?>" idd="<?php echo $timestamp; ?>"class="btn btn-warning btnLogout" ></td>
                                    <?php else : ?>
                                        <input type="button" value="Logout" disabled class="btn btn-warning" ></td>
                                    <?php endif; ?>
                            </tr>
                        <?php endwhile ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div id="logoutModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Are you sure to logout?</h4>
              </div>
              <div class="modal-body">
                <p>Your current duration since login is <h1 id='currentDuration'></h1></p>
                <form action='server/submitLogin.php'>
                    <input type="hidden" name="idToSend" id="idToSend" value=""/>
                    <input type="submit" value="Proceed" class="btn btn-success"/>
                </form>
              </div>
              
            </div>

          </div>
        </div>
        <script src="js/jquery.js"></script>
        <script src="js/jquery.validate.min.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/validation.js"></script>

    </body>
</html>
