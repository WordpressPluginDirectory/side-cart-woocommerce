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
						<label>Show</label>
						<div>
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

						</div>

					</div>


					<div class="xoo-wsc-accordion">

						<div class="xoo-wsc-acc-head"><span class="dashicons dashicons-plus-alt2"></span><span class="dashicons dashicons-minus"></span>Advanced</div>

						<div class="xoo-wsc-acc-cont xoo-wsc-bar-settings">

							<div class="xoo-wsc-barset-full xoo-wsc-bar-setgroup">
								<div class="xoo-wsc-bar-setting">
									<label>Allow Discount Checkpoints to Override Other Progress Bars</label>
									<input type="hidden" name="<?php echo $id ?>[overrideDiscount]" value="no">
									<input type="checkbox" value="yes" name="<?php echo $id ?>[overrideDiscount]" {{ data.overrideDiscount == 'yes' ? 'checked' : '' }}>
									<span class="xoo-scbhk-desc">When enabled, the highest discount milestone across all progress bars will take priority and override discounts from other progress bars. If disabled, the discount checkpoints in this progress bar will apply its own discount independently. </span>
								</div>

							</div>

						</div>

					</div>

				</div>


			</div>

			<div class="xoo-wsc-checkpoint-selector">
				<select>
					<option value="freeshipping">Free Shipping</option>
					<option value="gift">Free Gift</option>
					<option value="discount">Discount</option>
					<option value="display">Only for display</option>
				</select>
				<button type="button" class="button button-secondary xoo-wsc-bar-add-chkpoint">+ Add checkpoint</button>
			</div>

			<div class="xoo-wsc-bar-checkpoints"></div>

		</div>

	</div>
	

</script>