<?php global $_zp_themeroot; ?>
<div id="content-top-filler" class="opa20">
	&nbsp;
</div>

<div id="image-title" class="opa60 shadow">
	<div id="image-title-placeholder" class="right">
		Archives
	</div>
	<div class="left">
		<img id='archive-icon' src="<?= PersonalityUtil::getPersonaIconURL("archive", "$_zp_themeroot/resources/images/archive.png") ?>" width="64" height="64"/>
		<?php PersonalityUtil::printPersonalityIconSwitcher('archive'); ?>
	</div>
	<div id="current-month-placeholder" class="text left">
		&nbsp;
	</div>
	<div class="clear"></div>
</div>

<div>
	<div id="page-body">
		<div id="archive-wrapper" class="opa80">
    		<div class="prev left nav"><img width="10" height="10" src="<?= $_zp_themeroot ?>/resources/images/chevron_left.png" /></div>
			<div id="archive-carousel" class="left">
				<?php $years = SearchUtil::printAllDates($class='archive', $yearid='year', $monthid='month', $order='desc'); ?>	
			</div>
    		<div class="next left nav"><img width="10" height="10" src="<?= $_zp_themeroot ?>/resources/images/chevron.png" /></div>
			<div class="clear"></div>
		</div>
	</div>	
	<div>
	<?php 
	foreach ( $years as $year=>$months ) :
		echo "<div id='year-detail-wrapper-$year' class='year-detail-wrapper'><ul id='year-detail-$year' class='year-detail'>";
		foreach ( $months as $month=>$a ) :
			$link = SearchUtil::getArchiveMonthLink($year, $month, $a[0], $a[1], 'a');
			echo "<li text='$month $year'>$link</li>";
		endforeach;		
		echo "</ul></div>\n";	
	endforeach;
	?>
	</div>
</div>

<div id="image-wrap-scroll" class="archive">
	<div>
		<div id="image-wrapper">
			<div id="image-full-preview-container" class="opa80"></div>
		</div>	
	</div>

	<div id="scroller" class="opa80">
		<img id="left-scroll" src="<?= $_zp_themeroot ?>/resources/images/arrow_left_32.png" style="margin-right: 3px;"/>
		<img id="right-scroll" src="<?= $_zp_themeroot ?>/resources/images/arrow_right_32.png" />
	</div>
</div>


<div id="image-description" class="opa30" style="display: none"></div>
<div id="content-filler" class="opa20"></div>

<script type="text/javascript" src="<?= $_zp_themeroot ?>/resources/scripts/jcarousellite/jquery.carousellite-1.0.1.js"></script>
