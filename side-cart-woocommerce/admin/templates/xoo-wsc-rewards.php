<div id="rewards_bars" class="xoo-ass-section xoo-ass-rewards-bars">

	<div class="xoo-asc-head xoo-asc-bars">

		<div>
			<span class="xoo-as-icon xoo-icon-gift"></span>
			<span class="xoo-asch-title xoo-as-is-pro">Progress Bars & Rewards</span>
		</div>

		
	</div>

					
	<div class="xoo-wsc-rewards-cont">

		<div class="xoo-wsc-rwenb-cont">
			<div class="xoo-as-field" bis_skin_checked="1">
				<div class="xoo-as-label">Enable</div>
				<label class="xoo-as-switch">
					<input type="hidden" name="xoo-wsc-rewards-options[scbar-en]" value="no">
					<input name="xoo-wsc-rewards-options[scbar-en]" type="checkbox" value="yes" <?php echo xoo_wsc_helper()->get_rewards_option('scbar-en') === "yes" ? 'checked' : ''; ?>><span class="xoo-as-slider"></span>
				</label>
			</div>
		</div>

		<button type="button" class="xoo-btn xoo-btn-primary xoo-wsc-add-bar">+ Add a new progress bar</button>

		<div class="xoo-wsc-bars"></div>

	</div>

</div>