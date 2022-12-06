<?php $this->load->view('adminpanel/header.php'); ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    
    <h2>View Blog</h2>


    <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Title</th>
              <th scope="col">Description</th>
              <th scope="col">Images</th>
              <th scope="col">Edit</th>
              <th scope="col">Delete</th>
            </tr>
          </thead>
          <tbody>

            <?php
            if ($result) {
                $counter=1;
                foreach ($result as $key => $value) {
                    echo "<tr>
                            <td>".$counter."</td>
                            <td>".$value['blog_title']."</td>
                            <td>".$value['blog_desc']."</td>
                            <td><img src='".base_url().$value['blog_img']."' class='img-fluid' width='100'></td>
                            
                            <td><a class=\"btn btn-info\" href='".base_url().'admin/blog/editblog/'.$value['blogid']."'>Edit</a></td>
                            
                            <td><a class=\"btn btn-danger delete\" href='#.' data-id='".$value['blogid']."'>Delete</a></td>

                        </tr>";

                        $counter++;
                }

            }else{
                echo "<tr><td colspan='6'>No Records Found<td><tr>";
            }
            ?>
            
          </tbody>
        </table>
      </div>


</main>

<?php
$this->load->view('adminpanel/footer.php');
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script type="text/javascript">
    $('.delete').click(function(){

        var delete_id = $(this).attr('data-id');
        var bool = confirm('Are you sure you want to delete this blog?');
        // console.log (bool);

        if (bool) {
            //alert("Move to delete functionality using AJAX");
            $.ajax({
                url:'<?= base_url().'admin/blog/deleteblog/'?>'+delete_id,
                type:'post',
                data:{'delete_id': delete_id},
                success: function(response){
                    console.log(response);
                    if (response == "deleted"){
                        location.reload();
                    }else if (response == "notdeleted"){
                        alert("Something went wrong!");
                    }
                }
            });
        }else{
            alert("Your blog is safe");
        }
    });

    <?php
    
    if (isset($_SESSION['updated'])){
        if ($_SESSION['updated'] == "yes") {
            echo 'alert("Data has been updated!");';
        }else if($_SESSION['updated'] == "no") {
            echo 'alert("An error occured and your data was not updated.");';
        }
    }
    
    ?>


</script>