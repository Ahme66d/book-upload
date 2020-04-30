<?php require_once 'filesLogic.php';?>
<?php require_once 'header.php';?>


    <div class="container">
        <form action="downloads.php" method="post" 
        		enctype="multipart/form-data" >
          <h3 class="text-aligin-center">Upload File</h3>
          <input type="file" name="myfile"> <br>
          <button type="submit" name="save">upload</button>
        </form>
    </div>

 
<?php require_once 'footer.php';?>