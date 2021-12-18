<?php

$prepared_query = mysqli_query($conn,"SELECT * FROM allotment");

while($row = mysqli_fetch_array($prepared_query)){

$account_no = $row['account_no'];
$allotment = $row['allotment'];

mysqli_query($conn,"UPDATE shareholders SET total_share_subscribed = total_share_subscribed + $allotment WHERE account_no = '$account_no'");

}

?>