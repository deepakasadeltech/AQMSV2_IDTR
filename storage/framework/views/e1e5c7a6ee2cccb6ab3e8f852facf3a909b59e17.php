<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
    body{margin:0px; padding:0px;}
    .wrapper{ max-width:600px; margin:0px; padding:0px; background:#f2f2f2;}
    .wrapper table{ width:100%; margin:0px; border:1px solid #DDD; border-collapse:collapse;}
    .wrapper table tr > td{ border:1px solid #DDD; padding:8px 10px; text-transform:uppercase;}
    </style>
</head>
<body>
   <div class="wrapper">
   <table>
   <tr> <td>Doctor's Name : </td> <td> <?php echo $name['uname']; ?> </td> </tr>
   <tr> <td>Department Name : </td> <td> <?php echo $name['department_name']; ?> </td> </tr>
   <tr> <td>Counter Name : </td> <td> <?php echo $name['counter_name']; ?> </td> </tr>
   <tr> <td>Total Token Number Seen By You: </td> <td> <?php echo $name['total_token']; ?> </td> </tr>
   <tr> <td>Date : </td> <td> <?php echo date('Y-m-d H:i:s'); ?> </td> </tr>
   <tr> <td><strong>Patient Avg Time :</strong> </td> <td><strong> <?php echo $name['ttavgd']; ?> <sub style="font-size:12px;">&nbsp; Hrs / Patient</sub> </strong></td> </tr>

   </table>
   </div> 
</body>
</html>

 
   
