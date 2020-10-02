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
                <input class="form-field" type="text" id="title" name="title" value="<?= $advert->getTitle() ?>"
                       required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-field" id="description" name="description"
                          required><?= $advert->getDescription() ?></textarea>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input class="form-field" type="number" step="0.01" id="price" name="price"
                       value="<?= $advert->getPrice() ?>" required>
            </div>

            <div class="form-group">
                <label for="end_date">End date</label>
                <input class="form-field" type="date" id="end_date" name="end_date"
                       value="<?= date('Y-m-d', strtotime($advert->getDate())) ?>" required>
            </div>

            <div class="images--preview">
                <?php for ($i = 0; $i < 3; $i++): ?>
                    <div class="grid__2 mb-1">
                        <?php if (empty($advert->getImages()[$i][1]) === false): ?>
                            <img src="<?= ROOT . '/' . $advert->getImages()[$i][1] ?>" alt="">
                            <div class="actions">
                                <div class="absolute__center">
                                    <input class="form-field" type="file" name="advert_img[]">
                                    <div class="button button--red mt-1 delete--btn"
                                         data-id="<?= $advert->getImages()[$i][0] ?>">Delete image
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <img src="<?= ROOT . '/assets/images/choose_image.png' ?>" alt="">
                            <div class="actions">
                                <div class="absolute__center">
                                    <input class="form-field" type="file" name="advert_img[]">
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endfor; ?>
            </div>

            <button class="button button--green" type="submit" name="updateForm">Update</button>
            <a href="<?= ROOT . '/user/adverts' ?>" class="button button--red">Cancel and return to my adverts</a>
        </form>
    </div>
</div>
<script>
    const buttons = document.querySelectorAll('.delete--btn');

    for (const button of buttons) {
        button.addEventListener('click', (e) => {
            const xmlHttp = new XMLHttpRequest();

            xmlHttp.open('GET', '<?= ROOT . '/advert/deleteImage/' ?>' + button.getAttribute('data-id'), true);
            xmlHttp.send();

            xmlHttp.onload = () => {
                if (xmlHttp.status === 200) {
                    alert('Image successfully deleted');
                    window.location = window.location.href;
                }
            };
        });
    }
</script>
