<?php if (isset($error)): ?>
    <div class="alert alert__error">
        <?= $error ?>
    </div>
<?php elseif (isset($success)): ?>
    <div class="alert alert__success">
        <?= $success ?>
    </div>
<?php endif; ?>

<div class="text-center">
    <h2>Post an advert</h2>
    <div class="box w-60 m-auto mt-1">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title</label>
                <input class="form-field" type="text" id="title" name="title" placeholder="Enter a title" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-field" id="description" name="description"
                          placeholder="Enter a description of your product" required></textarea>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input class="form-field" type="number" step="0.01" id="price" name="price" placeholder="0" required>
            </div>

            <div class="form-group">
                <label for="end_date">End date</label>
                <input class="form-field" type="date" id="end_date" name="end_date" required>
            </div>

            <div class="form-group">
                <label for="user_img">First</label>
                <input class="form-field" type="file" name="advert_img[]">
            </div>

            <div class="form-group">
                <label for="user_img">Second</label>
                <input class="form-field" type="file" name="advert_img[]">
            </div>

            <div class="form-group">
                <label for="user_img">Third</label>
                <input class="form-field" type="file" name="advert_img[]">
            </div>

            <button class="button button--green" type="submit" name="createForm">Post</button>
            <a href="<?= ROOT . '/user/adverts' ?>" class="button button--red">Cancel and return to my adverts</a>
        </form>
    </div>
</div>
