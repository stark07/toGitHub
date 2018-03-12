<?php
//fetch.php
if(isset($_POST["query"]))
{
 $connect = mysqli_connect("localhost", "crude", "test1234", "crude1");
 $request = mysqli_real_escape_string($connect, $_POST["query"]);
 $query = "
  SELECT * FROM driver 
  WHERE name LIKE '%".$request."%' 
  OR address LIKE '%".$request."%' 
  OR email LIKE '%".$request."%'
 ";
 $result = mysqli_query($connect, $query);
 $data =array();
 $html = '';
 $html .= '
  <table class="table table-bordered table-striped">
   <tr>
    <th>Name</th>
    <th>Address</th>
    <th>Email</th>
   </tr>
  ';
 if(mysqli_num_rows($result) > 0)
 {
  while($row = mysqli_fetch_array($result))
  {
   $data[] = $row["name"];
   $data[] = $row["address"];
   $data[] = $row["email"];
   $html .= '
   <tr>
    <td>'.$row["name"].'</td>
    <td>'.$row["address"].'</td>
    <td>'.$row["email"].'</td>
   </tr>
   ';
  }
 }
 else
 {
  $data = 'No Data Found';
  $html .= '
   <tr>
    <td colspan="3">No Data Found</td>
   </tr>
   ';
 }
 $html .= '</table>';
 if(isset($_POST['typehead_search']))
 {
  echo $html;
 }
 else
 {
  $data = array_unique($data);
  echo json_encode($data);
 }
}

?>
