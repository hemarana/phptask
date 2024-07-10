<?php
include('db.php');
if(isset($_GET['delete'])){
    $id = mysqli_real_escape_string($con, $_GET['delete']);
    mysqli_query($con, "DELETE FROM $table WHERE Id=$id");
    echo 'success'; // Add this line to indicate success
    exit(); // Add this line to prevent further output
}
?>


<script>
$(document).ready(function(){
    $(".delete").on('click', function deleteRecord(){
        var id = this.id;
        var element = $(this); // Store reference to the element
        $.ajax({
            url: 'del_update.php',
            type: 'GET',
            data: {'id':id},
            success:function(response){
                if(response === 'success'){
                    element.closest('tr').remove(); // Use the stored reference
                }
            }
        });
    });
});

/*
function delal(){
    var confirmed = confirm('Are you sure you want to delete?');
    if (confirmed) {
        alert('Delete action confirmed.');
        // Perform delete operation here
    } else {
            alert('Delete action canceled.');
    }
}*/
</script>