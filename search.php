<?php
   include_once('./includes/headerNav.php')
?>


<div class="dynamic-data-container-search">
<span><h3 style="color:grey;margin-left:2.4%">Search:<?php if(isset($_POST['search']))echo $_POST['search']  ?></h3></span>
    
<?php
//Very important SEO friendly code generated by myself (practices)

 if( (isset($_POST['submit']) AND !(empty($_POST['search']))) OR isset($_GET['catag']) ){
   if(isset($_GET['catag'])){
    $search_term = mysqli_real_escape_string($conn, $_GET['catag']);
   }else{
    $search_term = mysqli_real_escape_string($conn, $_POST['search']);
   }


if(isset($_GET['page'])){
  $page = $_GET['page'];
}else{
  $page = 1;
}

include "includes/config.php";
/* define how much data to show in a page from database*/
$limit = 8;
//define from which row to start extracting data from database
$offset = ($page - 1) * $limit;

  //making search_term string to array each value separated by space
  $search_term_array = explode(" ",$search_term);
  for($search=0; $search<sizeof($search_term_array); $search++){ //loop for search

    $array_length = sizeof($search_term_array);
    if($array_length >1){ 
    $sql10 = "SELECT * FROM products 
    WHERE  products.product_title LIKE '%{$search_term_array[$search]}%' AND products.product_catag LIKE '%{$search_term_array[$search+1]}%'
    ORDER BY products.product_id DESC LIMIT {$offset},{$limit}";
    }
    if($array_length ==1){ 
      $sql10 = "SELECT * FROM products 
      WHERE  products.product_title LIKE '%{$search_term_array[$search]}%' OR products.product_catag LIKE '%{$search_term_array[$search]}%'
      ORDER BY products.product_id DESC LIMIT {$offset},{$limit}";
      }

    break;
 
  }
$result10 = $conn->query($sql10);

if ($result10->num_rows > 0) {
// output data of each row
while($row10 = $result10->fetch_assoc()) {
?>

<a href="product.php?id=<?php echo $row10['product_id']?>"><div class="product">
	<img class='image' src="images/<?php echo $row10['product_img'] ?>"  alt="product-img">
	<div class="detail-cont">
	<h5 class="title"><?php echo $row10['product_title'] ?> <p class="date"><?php echo $row10['product_date'] ?></p> </h5>
	<p class="description"><?php echo $row10['product_desc'] ?> 
	<p class="price"><b>Rs.<?php echo $row10['product_price'] ?></b><br><span class="discount"><strike>5000</strike> -8%</span></p>

	</div>
</div> </a>



<?php  }}else { echo "<h4 style='color:red; margin-left:8%;border:1px solid aliceblue'>"."No record found"."</h4>";}
             $conn->close(); 
            ?>


</div>


<!--Pagination-->
<div class="pag-cont-search">
<?php
                include "includes/config.php"; 
               // Pagination btn using php with active effects 

                $sql1 = "SELECT * FROM products";
                $result1 = mysqli_query($conn, $sql1) or die("Query Failed.");

                if(mysqli_num_rows($result1) > 0){

                  $total_products = mysqli_num_rows($result10);
                  $total_page = ceil($total_products / $limit);

                  echo "<div class='pagination'>";  
          
                  for($i=1; $i<=$total_page; $i++){

                    //important this is for active effects that denote in which page you are in current position
                    if($page==$i){
                      $active = "active";
                    }else{
                      $active = "";
                    }

                        echo "<a href='search.php?page={$i}' class='{$active}'>".$i."</a>";
                  }
            
                }
                echo "</div>";

               }//main if
               else{
                 echo "<h4 style='color:red; margin-left:8%;border:1px solid aliceblue'>"."ERR_Insert on Search"."</h4>";
               }
               ?>
	
</div>
