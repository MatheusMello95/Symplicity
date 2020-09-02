<?php $category = $data['categories'][0]; ?>
<div class="container">
    <h2 class="text-center">Category Details</h2><br><br>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $category->getId(); ?></td>
                <td><?= $category->getName(); ?></td>
                <td><?= $category->getDescription(); ?></td>
            </tr>
        </tbody>
    </table>
    <div class="row" style="float:right">
        <button type="button" class="btn btn-danger btn-form" onclick="history.back()">Back</button>
    </div>
</div>