<?php require_once 'header.php';?>
<?php require_once 'filesLogic.php';?>
</head>
<body>

<table class="table text-aligin-center">
<thead>
    <!---<th>Book Id</th>--->
    <th>Book Name</th>
    <th>Book Size</th>
    <th>Download Numbers</th>
    <th>Download</th>
</thead>
<tbody>

  <?php foreach ($files as $file): ?>
    <tr>
      <td><?php echo $file['id']; ?></td>
      <td><?php echo $file['book_name']; ?></td>
      <td><?php echo floor($file['book_size'] / 1000) . ' KB'; ?></td>
      <td><?php echo $file['downloads']; ?></td>
      <td><a class="link" href="downloads.php?file_id=<?php echo $file['id'] ?>">Download</a></td>
    </tr>
  <?php endforeach;?>

</tbody>
</table>


<?php require_once 'footer.php';?>
