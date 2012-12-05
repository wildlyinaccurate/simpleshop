You're about to purchase <strong><?php echo $product->getTitle(); ?></strong> for <?php echo Settings::get('currency'); ?><?php echo $product->getPrice(); ?>.

<?php var_dump($this->payments->oneoff_payment_button_method('google_checkout', $product->getPrice())); ?>
