<div class="blg-search">
        <span><form>
            <input type="text" value="" ng-model="search_text" id="txt-search" ng-keypress="($event.charCode==13)? normalSearch() : return" placeholder="ស្វែងរក">
        </form></span>
	<label id="btn-search" ng-model="btn_search" ng-click="normalSearch(btn_search)"></label>
</div><!--blg-search-->
<div class="blg-adv-search">
	<label id="adv-search" ng-model="adv_search" ng-click="toggleAdvSearch(adv_search)"></label>
	<div class="wrap-blg-adv">
		<div class="blg-adv">
			<div class="adv-cate">
				<p class="ttl-adv-search">បញ្ជីរស្វែងរក</p>
                <div class="wrap-cate-search">
                	<p class="adv-search-p">ប្រភពព័ត៌មាន</p>
                	 <div class="news-source">
		                <jqx-combo-box name="mef_viewer" ng-model="adv.source" required  jqx-settings="mef_viewer"></jqx-combo-box>
	                </div>
                    <p class="adv-search-p">ប្រភេទព័ត៌មាន</p>
	                <div class="news-source">
		                <jqx-combo-box jqx-on-select="selectTag(event)" jqx-on-unselect="unselectTag(event)" jqx-settings="mef_category"></jqx-combo-box>
	                </div>
                </div>
			</div>
			<div class="adv-date">
				<div class="row">
					<div class="col-xs-12">
						<label class="jqx-input-content">ចាប់ពីថ្ងៃ</label>
						<jqx-date-time-input   jqx-format-string="'yyyy-MM-dd'" jqx-height="25" ng-model="adv.fromdate" jqx-settings=""></jqx-date-time-input>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<label class="jqx-input-content">ដល់ថ្ងៃ</label>
						<jqx-date-time-input   jqx-format-string="'yyyy-MM-dd'" jqx-height="25" ng-model="adv.todate" jqx-settings=""></jqx-date-time-input>
					</div>
				</div>
				<div class="btn-adv-search" ng-click="advancedSearch()">ស្វែងរក</div>
			</div>
		</div><!--blg-adv-->
	</div>
</div>

