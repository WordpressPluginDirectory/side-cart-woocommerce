<script type="text/html" id="tmpl-xoo-as-chkpoint">

	<?php $id = $base_id.'[checkpoints][%#]' ?>

	<div class="xoo-wsc-bar-chkpoint xoo-wsc-accordion" data-type="{{data.type}}">

		<div class="xoo-wsc-acc-head"><span class="dashicons dashicons-plus-alt2"></span><span class="dashicons dashicons-minus"></span> <div class="xoo-wsc-chkpoint-title">{{data.title}}</div> <span class="dashicons dashicons-trash xoo-wsc-checkpoint-delete"></span></div>

		<div class="xoo-wsc-acc-cont xoo-wsc-chkpoint-settings">

			<input type="hidden" name="<?php echo $id ?>[type]" value="{{data.type}}">


			<# if ( data.type === "freeshipping" ) { #>
			<div class="xoo-scbhk-ship-title">
				<i>The checkpoint amount is fetched from Free shipping method ( woocommerce shipping settings ).<br> Please make sure you have a free shipping method available for customers' location.<br><a href="https://docs.xootix.com/side-cart-for-woocommerce/#shippingbar" target="__blank">Read more</a></i><br>
			</div>
			<# } #>

			<div class="xoo-wsc-chkpoint-setting">
				<input type="hidden" name="<?php echo $id ?>[enable]" value="no">
				<label><input type="checkbox" value="yes" name="<?php echo $id ?>[enable]" {{ data.enable == 'yes' ? 'checked' : '' }}> Enable</label>
			</div>

			<# if ( data.type === "discount" ) { #>

				<div class="xoo-wsc-chkpoint-setting">
					<label>Type</label>
					<select name="<?php echo $id ?>[discount_type]">
						<option value="percentage" {{ data.discount_type == 'percentage' ? 'selected' : '' }}>Percentage</option>
						<option value="amount" {{ data.discount_type == 'amount' ? 'selected' : '' }}>Fixed Amount</option>
					</select>
				</div>

			<# } #>

			<div class="xoo-wsc-chkpoint-setting">
				<label>Title</label>
				<input type="text" value="{{data.title}}" name="<?php echo $id ?>[title]" class="xoo-wsc-chkpoint-title-input">
			</div>

			<div class="xoo-wsc-chkpoint-setting">
				<label>Remaining Text</label>
				<input type="text" value="{{data.remaining}}" name="<?php echo $id ?>[remaining]">
				<span class="xoo-scbhk-desc">[value] is the remaining value to unlock this checkpoint</span>
			</div>

			

			<# if ( data.type !== "freeshipping" ) { #>
			<div class="xoo-wsc-chkpoint-setting">
				<label>Checkpoint Value</label>
				<input type="number" value="{{data.amount}}" step="any" name="<?php echo $id ?>[amount]">
				<span class="xoo-scbhk-desc">Value required to achieve this reward</span>
			</div>
			<# } #>

			

			<# if ( data.type === "gift" ) { #>


				<div class="xoo-wsc-chkpoint-setting xoo-wsc-gifts-choose">
					<input type="hidden" name="<?php echo $id ?>[choose]" value="no">
					<label><input type="checkbox" value="yes" name="<?php echo $id ?>[choose]" data-toggle="yes" {{ data.choose == 'yes' ? 'checked' : '' }}> Allow users to choose their own gift<span class="xoo-scbhk-desc"> </span></label>
				</div>

				<div class="xoo-wsc-chkpoint-setting xoo-wsc-max-gifts" style="display: none;">
					<label>Maximum gifts user can select</label>
					<input type="number" value="{{data.max_gifts}}" step="1" min="0" name="<?php echo $id ?>[max_gifts]" placeholder="0 for unlimited">
					<span class="xoo-scbhk-desc">Set 0 for unlimited selections, or specify maximum number of gifts</span>
				</div>

				<div class="xoo-wsc-chkpoint-setting xoo-wsc-bar-prodsearch">

					<label>Free Gift Products</label>

					<select class="wc-product-search" multiple="multiple" name="<?php echo $id ?>[gift_ids][]" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'woocommerce' ); ?>" data-action="woocommerce_json_search_products_and_variations">
					</select>

					<div class="xoo-wsc-barpsearch-defaults">
						<# _.each( data.gift_ids , function(option_value, index) { #>
							<input type="hidden" name="<?php echo $id ?>[gift_ids][]" value="{{option_value}}">
						<# }) #>
					</div>

					<span class="xoo-scbhk-desc">Add gift products</span>

				</div>

				<div class="xoo-wsc-chkpoint-setting xoo-wsc-bar-catsearch">

				    <label>Gifts from Product Categories</label>

				    <select class="wc-category-search" multiple="multiple" name="<?php echo $id ?>[gift_cat_ids][]" data-placeholder="<?php esc_attr_e( 'Search for a category&hellip;', 'woocommerce' ); ?>" data-action="woocommerce_json_search_categories" data-return_id="id"></select>

				    <div class="xoo-wsc-barpsearch-defaults">
				        <# _.each( data.gift_cat_ids , function(option_value, index) { #>
				            <input type="hidden" name="<?php echo $id ?>[gift_cat_ids][]" value="{{option_value}}" >
				        <# }) #>
				    </div>

				    <span class="xoo-scbhk-desc">Add gift categories</span>

				</div>


				<div class="xoo-wsc-chkpoint-setting">
					<label>Gift Quantity</label>
					<input type="number" value="{{data.gift_qty}}" step="any" name="<?php echo $id ?>[gift_qty]">
				</div>

				

				<div class="xoo-wsc-bar-setgroup xoo-wsc-barset-full">

					<div class="xoo-wsc-chkpoint-setting" style="width: 100%;">

						<label style="font-weight: bold;">Showcase gifts</label>
						<select name="<?php echo $id ?>[showcase]">
							<option value="always" {{ data.showcase == 'always' ? 'selected' : '' }}>Always</option>
							<option value="never" {{ data.showcase == 'never' ? 'selected' : '' }}>Never</option>
							<option value="show_before" {{ data.showcase == 'show_after' ? 'selected' : '' }}>Show until checkpoint is reached</option>
							<option value="show_after" {{ data.showcase == 'hide_before' ? 'selected' : '' }}>Show only after checkpoint is reached</option>
						</select>
						<span class="xoo-scbhk-desc">This will display your free gifts. If you've allowed users to choose their own gift or added a variable product as a free gift, make sure showcase is visible so customers can select their preferred variation.<br>If this is set to "Never", make sure to enable "Show added gifts in side cart" in Gift settings.</span>
					</div>

					<div class="xoo-wsc-chkpoint-setting">
						<label>Showcase pending text</label>
						<input type="text" value="{{data.showcase_beforetxt}}" name="<?php echo $id ?>[showcase_beforetxt]">
						<span class="xoo-scbhk-desc">[value] is the remaining value to unlock this checkpoint</span>
					</div>

					<div class="xoo-wsc-chkpoint-setting">
						<label>Showcase achieved text</label>
						<input type="text" value="{{data.showcase_achievedtxt}}" name="<?php echo $id ?>[showcase_achievedtxt]">
					</div>

					<div class="xoo-wsc-chkpoint-setting">
						<label>Gift Claimed Text</label>
						<input type="text" value="{{data.showcase_claimedtxt}}" name="<?php echo $id ?>[showcase_claimedtxt]">
					</div>

				</div>

				

			<# } #>


			<# if ( data.type === "discount" ) { #>
				<div class="xoo-wsc-chkpoint-setting">
					<label>Discount</label>
					<input type="number" value="{{data.discount}}" step="any" name="<?php echo $id ?>[discount]">
				</div>
			<# } #>
				

			<div class="xoo-wsc-bar-setgroup xoo-wsc-barset-full">

				<div class="xoo-wsc-chkpoint-setting">
					<label>Icon</label>
					<div>
						<input type="text" value="{{data.icon}}" name="<?php echo $id ?>[icon]" class="xoo-wsc-bar-icon">
						<i></i>
					</div>
				</div>

				<div class="xoo-wsc-chkpoint-setting">
					<label>Checkpoint Achieved Icon</label>
					<div>
						<input type="text" value="{{data.iconFilled}}" name="<?php echo $id ?>[iconFilled]" class="xoo-wsc-bar-icon">
						<i></i>
					</div>
				</div>

			</div>

			
		</div>

	</div>

</script>