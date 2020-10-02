<?php
$i = $nbIteration = 0;
?>

<h1 class="mb-1">My adverts (<?= count($adverts) ?>)</h1>
<section class="lastPost">
    <?php if (empty($adverts)): ?>
        <h2>There are no adverts</h2>
    <?php else: ?>
        <?php while ($i < count($adverts)): ?>
            <div class="lastAdverts__row">
                <?php for ($numAdvert = $i; $numAdvert < $i + 2; $numAdvert++):
                    if (isset($adverts[$numAdvert])): ?>
                        <a href="<?= ROOT . '/advert/show/' . $adverts[$numAdvert]->getId() ?>"
                           class="lastAdverts__row__block <?= $numAdvert % 3 == 0 ? "lastAdverts__row__block--large" : "" ?>"
                           style="background-image: url('<?= empty($adverts[$numAdvert]->getImages()) ? ROOT . '/assets/images/no_images.png' : ROOT . '/' . $adverts[$numAdvert]->getImages()[0][1] ?>');">
                            <div class="button button--blue mt-1 edit--btn"
                                 data-id="<?= $adverts[$numAdvert]->getId() ?>">
                                Edit advert
                            </div>
                            <div class="textBlock">
                                <div class="centeredText">
                                    <h1 class="textBlock--title"><?= $adverts[$numAdvert]->getTitle() ?></h1>
                                    <p class="textBlock--description">
                                        <b>Price </b> <?= $adverts[$numAdvert]->getPrice() ?>$
                                    </p>
                                </div>
                            </div>
                        </a>
                    <?php endif;
                endfor; ?>
            </div>
            <?php $i += 2;
            $nbIteration++;
        endwhile;
    endif; ?>
</section>
<script>
    const buttons = document.querySelectorAll('.edit--btn');

    for (const button of buttons) {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            location = '<?= ROOT . '/advert/update/' ?>' + button.getAttribute('data-id');
        });
    }
</script>
