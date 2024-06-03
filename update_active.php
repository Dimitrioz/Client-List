<?php
  // Check if the form has been submitted
  if (isset($_POST['active'])) {
    // Get the ID and active value from the form
    $id = intval($_POST['id']);
    $active = intval($_POST['active']);
    // Write the active value to a separate file
    file_put_contents("active_$id.txt", $active);
  }
?>

