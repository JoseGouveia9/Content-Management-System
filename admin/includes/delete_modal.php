<!-- Trigger the modal with a button -->
<!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button> -->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete</h4>
      </div>
      <div class="modal-body">
        <h3 class="text-center">Are you sure you want to delete this post?</h3>
      </div>
      <div class="modal-footer">
        <form action="" method="post">
            <!-- <input type="hidden" name="post_id" value="<?php echo $post_id ?>"> -->
            <input class="modal_delete_link" type="hidden" name="post_id" value="<?php echo $post_id ?>">
            <td><input class="btn btn-danger" type="submit" name="delete" value="Delete"></td>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </form>
        <!-- <a href="" class="btn btn-danger modal_delete_link">Delete</a> -->
        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> -->
      </div>
    </div>

  </div>
</div>