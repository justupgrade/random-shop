<section style='margin-top: 5px'>
	<a href='home.php?cart=true'>
		<fieldset>
			<legend>Cart</legend>
			<div class='margin-top-spacing'>
			Number of Products: <?php echo $cart->getNumberOfProducts(); ?><br>
			Total Cost: <?php echo $cart->getTotalCost(); ?>
			</div>
		</fieldset>
	</a>
</section>
