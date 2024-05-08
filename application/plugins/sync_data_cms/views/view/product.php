<?php
use Warranty\Models\KiotProduct;
 ?>
<td data-title="<?php echo __('note',$currentvalue) ?>">
<?php $value =  $currentitem[$currentvalue['name']]; ?>
<?php
$product = KiotProduct::find($value);
if(!$product->isEmpty()):
 ?>
 <span><?php echo $product->name ?></span>
 <?php endif ?>
</td>