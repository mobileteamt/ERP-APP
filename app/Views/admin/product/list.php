<div class="d-flex justify-content-between align-items-center">
    <h3 class="py-4">Products</h3>
    <a type="button" href="<?= base_url()."admin/add-product" ?>" class="btn btn-primary">Add New</a>
</div>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th scope="col">Discount Status</th>
                <th scope="col">Discounted Price</th>
                <th scope="col">Status</th>
                <th scope="col">Created at</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if(isset($products) && count($products)>0){ ?>
            <?php foreach($products as $product){ ?> 
                <tr>
                    <td><?= $product->product_id; ?></td>
                    <td><?= $product->name; ?></td>
                    <td><?= $product->quantity; ?></td>
                    <td><?= $product->price; ?></td>
                    <td><?= $product->discount_status; ?></td>
                    <td><?= $product->discounted_price; ?></td>
                    <td><?= $product->status; ?></td>
                    <td><?= $product->created_at; ?></td>
                    <td>
                        <a href="<?= base_url()."admin/edit-product/".$product->product_id;?>"><span class="badge text-bg-success">Edit</span></a>
                        <a onclick="deleteLead(<?php echo $product->product_id;?>);" class="btn-pointer"><span class="badge text-bg-danger">Delete</span></a>
                    </td>
                </tr>
            <?php } } else { ?>
                <tr><td colspan="9"><?= "No Record Found!" ?></td></tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script>
    var baseURL = '<?= base_url(); ?>';
    function deleteLead(id){
        var result = window.confirm("Are you sure you want to delete this product?");
        if(result){
            window.location.href = baseURL+"admin/delete-product/"+id;
        }
        else{
            return false;
        }
    }
</script>