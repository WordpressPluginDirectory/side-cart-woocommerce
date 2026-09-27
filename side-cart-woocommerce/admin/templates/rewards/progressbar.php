<script type="text/html" id="tmpl-xoo-as-bar">

	<?php $id = $base_id.'[settings]' ?>
	
	<div class="xoo-wsc-bar xoo-wsc-accordion">

		<div class="xoo-wsc-acc-head xoo-wsc-bar-head"><span class="dashicons dashicons-plus-alt2"></span><span class="dashicons dashicons-minus"></span><div class="xoo-wsc-bar-title">{{data.barTitle}}</div><span class="dashicons dashicons-trash xoo-wsc-bar-delete"></span></div>


		<div class="xoo-wsc-acc-cont">

			<div class="xoo-wsc-bar-settings xoo-wsc-bar-mainset">
				<div class="xoo-wsc-bar-setting" data-barset="enable">
					<label>Enable</label>
					<input type="hidden" name="<?php echo $id ?>[enable]" value="no">
					<div><input type="checkbox" name="<?php echo $id ?>[enable]" value="yes" {{ data.enable == 'yes' ? 'checked' : '' }}></div>
				</div>


				<div class="xoo-wsc-bar-setting">
					<label>Progress bar title</label>
					<input type="text" value="{{data.barTitle}}" name="<?php echo $id ?>[barTitle]" class="xoo-wsc-bar-title-input">
				</div>

			</div>

			<div class="xoo-wsc-bar-settings-cont xoo-wsc-accordion xoo-wsc-acc-active">

				<div class="xoo-wsc-acc-head"><span class="dashicons dashicons-plus-alt2"></span><span class="dashicons dashicons-minus"></span>Settings</div>

				<div class="xoo-wsc-acc-cont xoo-wsc-bar-settings">

					<div class="xoo-wsc-bar-setting">
						<label>Bar Value</label>
						<select name="<?php echo $id ?>[barValue]" class="xoo-wsc-bar-barValue">
							<?php $this->bar_selectedoptions( 'barValue', array(
								'total' 		=> 'Cart Total',
								'subtotal' 		=> 'Cart Subtotal',
								'subtotal_tax' 	=> 'Cart Subtotal including Tax',
								'quantity' 		=> 'Cart Quantity'
							) ) ?>
						</select>
					</div>

					<div class="xoo-wsc-bar-setting xoo-wsc-barset-multiplebox">
						<label>Bar elements to show</label>
						<div>
							<label><input type="checkbox" value="bar" class="xoo-wscbarshow-bar" name="<?php echo $id ?>[show][]" {{ data.show && data.show.includes('bar') ? 'checked' : '' }}>Bar</label>
							<label><input type="checkbox" value="remaining" name="<?php echo $id ?>[show][]" {{ data.show && data.show.includes('remaining') ? 'checked' : '' }}>Remaining</label>
							<label><input type="checkbox" value="amount" name="<?php echo $id ?>[show][]" {{ data.show && data.show.includes('amount') ? 'checked' : '' }}>Amount</label>
							<label><input type="checkbox" value="title" name="<?php echo $id ?>[show][]" {{ data.show && data.show.includes('title') ? 'checked' : '' }}>Title</label>
							<label><input type="checkbox" value="icon" name="<?php echo $id ?>[show][]" {{ data.show && data.show.includes('icon') ? 'checked' : '' }}>Icon</label>
						</div>
					</div>

					<div class="xoo-wsc-bar-setting">
						<label>Bar Location</label>
						<select name="<?php echo $id ?>[location]">
							<?php $this->bar_selectedoptions( 'location', array(
								'xoo_wsc_header_end' 	=> 'Header',
								'xoo_wsc_body_start' 	=> 'Before Products',
								'xoo_wsc_body_end' 		=> 'After Products',
								'xoo_wsc_footer_start' 	=> 'Footer Start',
								'xoo_wsc_footer_end' 	=> 'Footer end',
							) ) ?>
						</select>
					</div>

					<div class="xoo-wsc-bar-setting xoo-wsc-barset-full">
						<label>Progress bar completed text</label>
						<input type="text" value="{{data.comptxt}}" name="<?php echo $id ?>[comptxt]">
					</div>


					<div class="xoo-wsc-barset-full xoo-wsc-bar-setgroup" data-group="free_gift">

						<h4 style="width: 100%; margin: 0;">Free Gift Showcase</h4>

						<div class="xoo-wsc-bar-setting xoo-wsc-barset-multiplebox" style="margin-bottom: 10px;">
							<label>Show</label>

							<div>
								<label><input type="checkbox" value="bar" name="<?php echo $id ?>[showcase][]" {{ data.showcase && data.showcase.includes('bar') ? 'checked' : '' }}>Gift Bar</label>
								<label><input type="checkbox" value="added_gifts" name="<?php echo $id ?>[showcase][]" {{ data.showcase && data.showcase.includes('added_gifts') ? 'checked' : '' }}>Gifts added to cart</label>
								<label><input type="checkbox" value="unavailable_gifts" name="<?php echo $id ?>[showcase][]" {{ data.showcase && data.showcase.includes('unavailable_gifts') ? 'checked' : '' }}>Unavailable Gifts</label>
							</div>

						</div>

					</div>

					<div class="xoo-wsc-barset-full  xoo-wsc-bar-setgroup" data-group="free_gift">
						<div class="xoo-wsc-bar-setting">
							<label>Gift Showcase Heading</label>
							<input type="text" value="{{data.gift_showcase_heading}}" name="<?php echo $id ?>[gift_showcase_heading]">
						</div>

						<div class="xoo-wsc-bar-setting">
							<label>Gift Showcase Heading on checkpoint achieved</label>
							<input type="text" value="{{data.gift_showcase_heading_achieved}}" name="<?php echo $id ?>[gift_showcase_heading_achieved]">
						</div>
					</div>

					<div class="xoo-wsc-accordion">

						<div class="xoo-wsc-acc-head"><span class="dashicons dashicons-plus-alt2"></span><span class="dashicons dashicons-minus"></span>Style</div>

						<div class="xoo-wsc-acc-cont xoo-wsc-bar-settings">

							<div class="xoo-wsc-barset-full xoo-wsc-bar-setgroup">
								<div class="xoo-wsc-bar-setting xoo-wsc-barColorPicker">
									<label>Bar Color</label>
									<input type="text" value="{{data.emptyColor}}" name="<?php echo $id ?>[emptyColor]">
								</div>

								<div class="xoo-wsc-bar-setting xoo-wsc-barColorPicker">
									<label>Bar Filled Color</label>
									<input type="text" value="{{data.filledColor}}" name="<?php echo $id ?>[filledColor]">
								</div>


								<div class="xoo-wsc-bar-setting xoo-wsc-barColorPicker">
									<label>Bar Text Color</label>
									<input type="text" value="{{data.textColor}}" name="<?php echo $id ?>[textColor]">
								</div>

							</div>

							<div class="xoo-wsc-barset-full xoo-wsc-bar-setgroup">
								<div class="xoo-wsc-bar-setting xoo-wsc-barColorPicker">
									<label>Icon Color</label>
									<input type="text" value="{{data.iconColor}}" name="<?php echo $id ?>[iconColor]">
								</div>

								<div class="xoo-wsc-bar-setting xoo-wsc-barColorPicker">
									<label>Icon Background Color</label>
									<input type="text" value="{{data.iconBGColor}}" name="<?php echo $id ?>[iconBGColor]">
								</div>


								<div class="xoo-wsc-bar-setting">
									<label>Icon Border</label>
									<input type="text" value="{{data.iconBorder}}" name="<?php echo $id ?>[iconBorder]">
								</div>

							</div>


							<div class="xoo-wsc-barset-full xoo-wsc-bar-setgroup">

								<h4 style="width: 100%; margin: 0;">Checkpoint Achieved </h4>

								<div class="xoo-wsc-bar-setting xoo-wsc-barColorPicker">
									<label>Icon Color</label>
									<input type="text" value="{{data.iconColorFilled}}" name="<?php echo $id ?>[iconColorFilled]">
								</div>

								<div class="xoo-wsc-bar-setting xoo-wsc-barColorPicker">
									<label>Icon Background Color</label>
									<input type="text" value="{{data.iconBGColorFilled}}" name="<?php echo $id ?>[iconBGColorFilled]">
								</div>


								<div class="xoo-wsc-bar-setting">
									<label>Icon Border</label>
									<input type="text" value="{{data.iconBorderFilled}}" name="<?php echo $id ?>[iconBorderFilled]">
								</div>

							</div>

							<div class="xoo-wsc-barset-full xoo-wsc-bar-setgroup">

								<h4 style="width: 100%; margin: 0;">Container</h4>

								<div class="xoo-wsc-bar-setting xoo-wsc-barColorPicker">
									<label>Background Color</label>
									<input type="text" value="{{data.contBGColor}}" name="<?php echo $id ?>[contBGColor]">
								</div>

								<div class="xoo-wsc-bar-setting">
									<label>Font Size</label>
									<input type="number" value="{{data.fontSize}}" name="<?php echo $id ?>[fontSize]">
								</div>

							</div>

							<div class="xoo-wsc-barset-full xoo-wsc-bar-setgroup">

								<div class="xoo-wsc-bar-setting">
									<label>Padding</label>
									<input type="text" value="{{data.contPadding}}" name="<?php echo $id ?>[contPadding]">
									<span class="xoo-scbhk-desc">↨ ⟷ ( Default: 15px 20px )</span>
								</div>


								<div class="xoo-wsc-bar-setting">
									<label>Margin</label>
									<input type="text" value="{{data.contMargin}}" name="<?php echo $id ?>[contMargin]">
									<span class="xoo-scbhk-desc">↨ ⟷ ( Default: 0px 0px )</span>
								</div>

							</div>

							<div class="xoo-wsc-barset-full xoo-wsc-bar-setgroup xoo-wsc-bar-showcase-set" data-group="free_gift">

								<h4 style="width: 100%; margin: 0;">Gifts Showcase</h4>

								<div class="xoo-wsc-bar-setting">
									<label>Container Border</label>
									<input type="text" value="{{data.showcaseBorder}}" name="<?php echo $id ?>[showcaseBorder]">
								</div>

								<div class="xoo-wsc-bar-setting xoo-wsc-barColorPicker">
									<label>Background Color</label>
									<input type="text" value="{{data.showcaseBGColor}}" name="<?php echo $id ?>[showcaseBGColor]">
								</div>


								<div class="xoo-wsc-bar-setting xoo-wsc-barColorPicker">
									<label>Text Color</label>
									<input type="text" value="{{data.showcaseTxtColor}}" name="<?php echo $id ?>[showcaseTxtColor]">
								</div>

								<div class="xoo-wsc-bar-setting xoo-wsc-barColorPicker">
									<label>Heading Color</label>
									<input type="text" value="{{data.showcaseHeadingColor}}" name="<?php echo $id ?>[showcaseHeadingColor]">
								</div>

								<div class="xoo-wsc-bar-setting xoo-wsc-barColorPicker">
									<label>Bar Container Background Color</label>
									<input type="text" value="{{data.showcaseBarBGColor}}" name="<?php echo $id ?>[showcaseBarBGColor]">
								</div>

								<div class="xoo-wsc-bar-setting xoo-wsc-barColorPicker">
									<label>Bar Container Text Color</label>
									<input type="text" value="{{data.showcaseBarTxtColor}}" name="<?php echo $id ?>[showcaseBarTxtColor]">
								</div>

								


							</div>

						</div>

					</div>


					<div class="xoo-wsc-accordion">

						<div class="xoo-wsc-acc-head"><span class="dashicons dashicons-plus-alt2"></span><span class="dashicons dashicons-minus"></span>Advanced</div>

						<div class="xoo-wsc-acc-cont xoo-wsc-bar-settings">

							<div class="xoo-wsc-barset-full xoo-wsc-bar-setgroup">

								<div class="xoo-wsc-bar-setting" data-barset="filter-byproduct">
									<label>Filter by Product - Calculate Bar Value based on</label>
									<select name="<?php echo $id ?>[filter_byproducts]" >
										<?php $this->bar_selectedoptions( 'filter_byproducts', array(
											'no' 					=> 'all products in cart',
											'allowed_products' 		=> 'only selected products',
											'except_products' 		=> 'all except selected products',
										) ) ?>
									</select>
									<span class="xoo-scbhk-desc">Example: Give a reward when the cart total reaches $100, but exclude a specific product. The price of this product will not be included in the $100 calculation.</span>
									
								</div>

								<div class="xoo-wsc-bar-setting xoo-wsc-bar-prodsearch" data-barset="filter-byproductsearch">

									<label>Products</label>

									<select class="wc-product-search" multiple="multiple" name="<?php echo $id ?>[filter_product_ids][]" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'woocommerce' ); ?>" data-action="woocommerce_json_search_products_and_variations">
									</select>

									<div class="xoo-wsc-barpsearch-defaults">
										<# _.each( data.filter_product_ids , function(option_value, index) { #>
											<input type="hidden" name="<?php echo $id ?>[filter_product_ids][]" value="{{option_value}}">
										<# }) #>
									</div>

									<span class="xoo-scbhk-desc">The Bar Value & rewards will be calculated based on these products in the cart.</span>
								</div>


								<div class="xoo-wsc-bar-setting xoo-wsc-barset-full" data-barset="product-noteligbtxt">
									<label>Product not eligible for rewards title.</label>
									<input type="text" value="{{data.productNotEligibleTxt}}" name="<?php echo $id ?>[productNotEligibleTxt]">
									<span class="xoo-scbhk-desc">Leave empty to disable the message.</span>
								</div>



							</div>

							<div class="xoo-wsc-barset-full xoo-wsc-bar-setgroup" data-group="free_gift">
								<div class="xoo-wsc-bar-setting">
									<div class="xoo-wsc-bar-setchkbox">
										<label>Free Gift - Limit to Highest Gift</label>
										<input type="hidden" name="<?php echo $id ?>[highestGift]" value="no">
										<input type="checkbox" value="yes" name="<?php echo $id ?>[highestGift]" {{ data.highestGift == 'yes' ? 'checked' : '' }}>
									</div>
									<span class="xoo-scbhk-desc">If you have multiple "Free Gift" checkpoints and only want to award the gift from the highest checkpoint, enable this option. </span>
								</div>

							</div>


							<div class="xoo-wsc-barset-full xoo-wsc-bar-setgroup">
								<div class="xoo-wsc-bar-setting">
									<div class="xoo-wsc-bar-setchkbox">
										<label>Grant Reward Only for Highest Checkpoint</label>
										<input type="hidden" name="<?php echo $id ?>[highestReward]" value="no">
										<input type="checkbox" value="yes" name="<?php echo $id ?>[highestReward]" {{ data.highestReward == 'yes' ? 'checked' : '' }}>
									</div>
									<span class="xoo-scbhk-desc">Enable this option to grant rewards only for the highest checkpoint reached. Rewards from previously completed checkpoints will be skipped.<br>Example: If a customer reaches checkpoint 5, only the reward for checkpoint 5 will be granted. Rewards for checkpoints 1–4 will be skipped. </span>
								</div>

							</div>

							<div class="xoo-wsc-barset-full xoo-wsc-bar-setgroup">
								<div class="xoo-wsc-bar-setting">
									<div class="xoo-wsc-bar-setchkbox">
										<label>Discount - Use Highest Discount Across All Bars</label>
										<input type="hidden" name="<?php echo $id ?>[overrideDiscount]" value="no">
										<input type="checkbox" value="yes" name="<?php echo $id ?>[overrideDiscount]" {{ data.overrideDiscount == 'yes' ? 'checked' : '' }}>
									</div>
									<span class="xoo-scbhk-desc">When enabled, the highest discount milestone across all progress bars will take priority and override discounts from other progress bars. If disabled, the discount checkpoints in this progress bar will apply its own discount independently. </span>
								</div>

							</div>

						</div>

					</div>

				</div>


			</div>

			<p class="xoo-wsc-freeshipnotice">Free Shipping checkpoint is not available when "Filter by products" is enabled</p>

			<div class="xoo-wsc-checkpoint-selector">
				<select>
					<option value="freeshipping">Free Shipping</option>
					<option value="gift">Free Gift</option>
					<option value="discount">Discount</option>
					<option value="display">Only for display</option>
				</select>
				<button type="button" class="xoo-btn xoo-secondary-btn xoo-wsc-bar-add-chkpoint">+ Add checkpoint</button>
			</div>

			<div class="xoo-wsc-bar-checkpoints"></div>

		</div>

	</div>
	

</script>