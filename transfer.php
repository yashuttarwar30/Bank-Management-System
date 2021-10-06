<html>
<head>
<title></title>
<link rel="stylesheet" type="text/css" href="css/userstyle.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@100;400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

.navbar
{
    width:100%;
    white-space:nowrap;
    background-color: #5E11A3;
}
.main_div
{
    width:100%;
    height:100vh;
 
}
   input
  {
      margin-top:10px;
      width:230px;
      height:40px;
      border-radius:5px;
      outline:none;
  }
 ::placeholder
 {
     padding:10px;
     color:orange;
 }
button
{
    color:#7A3DAF;
    background:white;
    border-color:#7A3DAF;
   padding: 14px 20px;
  cursor: pointer;
  width: 100%;
    
}
button:hover
 {
     color:white;
     background:#4CAF50;
     border:none;
     opacity:0.8;
 }


 </style>
</head>
<body>
<div class="main_div">
 
     <div class="navbar navbar-expand-md">
   
      <a href="#" class="navbar-brand font-weight-bold text-white text-center">YGU BANK</a>
      <button class="navbar-toggler text-white " type="button" data-toggle="collapse" data-target="#collapsenavbar">
      <span class="navbar-toggler-icon" style="background:white;"></span>
      </button>
     
       <div class="collapse navbar-collapse text-center" id="collapsenavbar">
          <ul class="navbar-nav ml-auto">
              
                  <a href="transfermoney" class="nav-link text-white"></a></li>
              <li class="nav-item">
              
                  <a href="transaction.php" class="nav-link text-white">Transaction History</a></li>
                      
               </ul>
        </div>
     </div>


     <div class="container">
        <div class="row">

          <div class="col-sm-4">
              <div class="card text-center" style="margin-top:76px;background-color:#7A3DAF;border-radius:10px;color:white" >
              <form method="POST">  
                                              
 <?php
include 'connection.php';
$ids=$_GET['idtransfer'];
$showquery="select * from `user` where ID=($ids) ";
$showdata=mysqli_query($conn,$showquery);
if (!$showdata) {
  printf("Error: %s\n", mysqli_error($conn));
  exit();
}
$arrdata=mysqli_fetch_array($showdata);

?> 
                     
                    <div class="card-body">
                     
                    <h3>Transfer Details</h3>
                  


                        <label>Name</label>
                        <input type="text"  name="name1" value="<?php echo $arrdata['NAME']; ?>" /><br><br>
                        <label>Email</label>
                        <input type="text" name="email1" value="<?php echo $arrdata['EMAIL']; ?>" /><br><br>
                        <label>Amount</label>
                        <input type="text" name="amount1" value="" style="width:210px;" required placeholder="Enter amount"/><br><br>
                        <img src="sender.jpeg" style="width:200px ;height:200px;">
                    </div>

               </div>
          </div>
           
          <div class="col-sm-4">
              <div class="card text-center" style="margin-top:60px;height:380px;">
                   <div class="card-body">
                   
                   <button  name="submit">Proceed to Pay</button>
                   <img src="trans.jpeg" style="width:200px ;height:200px;">
                  </div>
             </div>
          </div>

          <div class="col-sm-4">
                <div class="card text-center" style="margin-top:76px;background-color:#7A3DAF;border-radius:10px;color:white">
                   
                   <div class="card-body">
                   <h3>Transfer Details</h3>
                  
                        <label>Name</label>
                        <input type="text"  name="name2" value="" required placeholder="Enter your name"/><br><br>
                        <label>Email</label>
                        <input type="text" name="email2" value="" required placeholder="Enter email id"/><br><br>
                        <img src="r1.jpeg" style="width:200px ;height:200px;">
                   
                 
                    
                   </div>

               </div>
          </div>

       </div>
       
    </div>
</div>
</form> 
<?php

include 'connection.php';

if(isset($_POST['submit']))
{
    
  
    $Sender_name=$_POST['name1'];
    $Sender_email=$_POST['email1'];
    $Sender=$_POST['amount1'];
    $Receiver_name=$_POST['name2'];
    $Receiver_email=$_POST['email2'];
     
  

    $ids=$_GET['idtransfer'];
    $senderquery="select * from `user` where ID=$ids ";
    $senderdata=mysqli_query($conn,$senderquery);
  
    if (!$senderdata) {
     printf("Error: %s\n", mysqli_error($conn));
    exit();
    }
    $arrdata=mysqli_fetch_array($senderdata);

    //receiverquery
    $receiverquery="select * from `user` where EMAIL='$Receiver_email' ";
    $receiver_data=mysqli_query($conn,$receiverquery);
   
    if (!$receiver_data) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
    }
    $receiver_arr=mysqli_fetch_array($receiver_data);
    $id_receiver=$receiver_arr['ID'];
    
    $traname=$arrdata['NAME'];
    $tranrename=$receiver_arr['NAME'];

    if($arrdata['AMOUNT'] >= $Sender)
    {
      $decrease_sender=$arrdata['AMOUNT'] - $Sender;
      $increase_receiver=$receiver_arr['AMOUNT'] + $Sender;
       $query="UPDATE `user` SET `ID`=$ids,`AMOUNT`= $decrease_sender  where `ID`=$ids ";
       $rec_query="UPDATE`user` SET `ID`=$id_receiver,`AMOUNT`= $increase_receiver where  `ID`=$id_receiver ";
       $res= mysqli_query($conn,$query);
       $rec_res= mysqli_query($conn,$rec_query);
       $sta="SUCCESS";
       $tran_query="Insert into transfer(`Sender_Name`,`Reciever_Name`,`Amount`,`STATUS`) values('$traname','$tranrename','$Sender','$sta')";
       $query1=mysqli_query($conn,$tran_query);
      // $res_receiver=mysqli_query($con,$query_receiver);
       if($res && $rec_res)
      {
        $sta="SUCCESS";
        $tran_query="Insert into transfer(`Sender_Name`,`Reciever_Name`,`Amount`,`STATUS`) values('$traname','$tranrename','$Sender','$sta')";
        $query1=mysqli_query($conn,$tran_query);
       ?>
       <script>
       swal("Done!", "Transaction Successful!", "success");
        </script> 
    
      <?php
   
      }
      else
      {
        $sta1="ERROR";
        $tran_query1="Insert into transfer(`Sender_Name`,`Reciever_Name`,`Amount`,`STATUS`) values('$traname','$tranrename','$Sender','$sta1')";
        $query1=mysqli_query($conn,$tran_query1);
      ?>
           <script>
       swal("Error!", "Error Occured!", "error");
        </script> 

      <?php
      
      }
    }
  

  else
 {
    $sta2="INSUFICIENT BALANCE";
    $tran_query2="Insert into transfer(`Sender_Name`,`Reciever_Name`,`Amount`,`STATUS`) values('$traname','$tranrename','$Sender','$sta2')";
    $query1=mysqli_query($conn,$tran_query2);
  ?>
    <script>
       swal("Insufficient Balance", "Transaction Not  Successful!", "warning");
        </script> 
  <?php
   
 }
 
}
?>