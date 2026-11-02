                        <?php
                        $image = $img($item['image_url'] ?? null);
                        $isCollection = !empty($item['collection_id']);
                        $href = $isCollection ? $u('index.php#bundles') : $u('index.php?page=product&id=' . (int) $item['pro_id']);
                        ?>
                        <article class="cx-line">
                            <a class="cx-line-img" href="<?= $href ?>">
                                <?php if ($image): ?>
                                    <img src="<?= e($image) ?>" alt="<?= e($item['name']) ?>" loading="lazy">
                                <?php else: ?>
                                    <span>NABTA</span>
                                <?php endif; ?>
                            </a>

                            <div>
                                <h2 class="cx-line-name">
                                    <a href="<?= $href ?>"><?= e($item['name']) ?></a>
                                </h2>
                                <p class="cx-line-meta">
                                    <?= e($item['category'] ?? 'NABTA') ?>
                                    <?php if ($isCollection && !empty($item['includes'])): ?>
                                        · <?= e(implode(', ', $item['includes'])) ?>
                                    <?php endif; ?>
                                </p>
                                <label class="sr-only" for="<?= e($quantityPrefix) ?>-qty-<?= (int) $item['cart_item_id'] ?>" style="position:absolute;left:-9999px">Quantity for <?= e($item['name']) ?></label>
                                <input class="cx-qty" data-basket-quantity="<?= (int)$item['cart_item_id'] ?>" id="<?= e($quantityPrefix) ?>-qty-<?= (int) $item['cart_item_id'] ?>" type="number" inputmode="numeric"
                                       name="qty[<?= (int) $item['cart_item_id'] ?>]" value="<?= (int) $item['quantity'] ?>"
                                       min="1" max="<?= max(1, (int) $item['stock']) ?>">
                            </div>

                            <div class="cx-line-side">
                                <span class="cx-line-price"><?= $money((float) $item['price'] * (int) $item['quantity']) ?></span>
                                <button class="cx-remove" type="submit" form="remove-<?= (int) $item['cart_item_id'] ?>">Remove</button>
                            </div>
                        </article>
