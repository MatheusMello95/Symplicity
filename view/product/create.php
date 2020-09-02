<script>
    $(document).ready(function() {
        $('.money').mask("###0.00", {
            reverse: true
        });
    });
    const toBase64 = (file) => {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => resolve(reader.result);
            reader.onerror = error => reject(error);
        });
    };

    const uploadFile = async (files) => {
        document.getElementById('image').value = await toBase64(files[0]);
        document.getElementById('img-image').src = await toBase64(files[0]);
    }
</script>
<div class="container">
    <?php $categories = $data['categories']; ?>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-8 offset-md-2">
                <?php if (isset($data['errors'])) {
                    echo '<div class="alert alert-danger" role="alert">';
                    echo '<ul>';
                    foreach ($data['errors'] as $error) {
                        echo '<li>' . $error . '</li>';
                    }
                    echo '</ul>';
                    echo '</div>';
                }
                ?>
                <!-- form new category -->
                <div class="card card-outline-secondary">
                    <div class="card-header">
                        <h3 class="mb-0">New Product</h3>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" method="post" action="index.php?product=store">
                            <div class="align-middle">
                                <div class="align-middle">
                                    <div class="form-group align-middle">
                                        <label class="control-label col-sm-2" for="name">Name:</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="name" placeholder="Product name" name="name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-4" for="description">Description:</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="description" placeholder="Description" name="description">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-4" for="image">Photo:</label>
                                        <div class="col-sm-12">
                                            <input type="file" name="image-upload" onchange="uploadFile(this.files)">
                                            <input type="hidden" id="image" name="image">
                                        </div>
                                        <div class="col-sm-12 mt-3">
                                            <img src="./assets/images/noimage.png" class="list-img" alt="" id="img-image">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="price">Price:</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control money" id="price" placeholder="Price" name="price">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-4" for="category">Category:</label>
                                        <div class="col-sm-4">
                                            <select name="category" id="category" class="form-control">
                                                <?php foreach ($categories as $category) : ?>
                                                    <option value="<?php echo $category->getId(); ?>"><?php echo $category->getName(); ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-primary btn-form">Save</button>
                                            <a href="index.php?product=index"><button type="button" class="btn btn-danger btn-form">Cancel</button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>