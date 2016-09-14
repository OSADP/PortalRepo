
<?php
	JHTML::stylesheet('administrator/components/com_akeebacustom/styles/akeeba.form.css');
	JHTML::script('https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js');
	JHTML::script('administrator/components/com_akeebacustom/scripts/akeeba.custom.min.js');
?>

<div class="row-fluid" ng-app="AkeebaCustomModule" ng-cloak>

		<div class="span4 akeeba__form">
			<legend class="akeeba__form-legend"><abbr title="Akeeba Release System">ARS</abbr> Category Custom Information</legend>
			<fieldset ng-controller="CategoryCustomsCtrl as category">
				<div akeeba-alert></div>
				<div class="akeeba__form-group">
					<div class="span4" class="akeeba_category-icon">
						<div class="akeeba__category-icon-wrapper">
							<img src="/administrator/components/com_akeebacustom/images/osadp-logo-blue.png" alt="" ng-if="! category.active.icon_url" style="opacity: .2;">
							<img ng-src="{{ category.active.icon_url || '' }}" alt="" ng-if="category.active.icon_url">
						</div>
					</div>
					<div class="span8">
						<div class="akeeba__form-group-mimic-input">
							<select ng-model="category.select" ng-init="category.select = 'all'" ng-change="category.changeActive(category)">
								<option value="all">Select Category</option>
								<option ng-repeat="category in category.categories" value="{{ category.id }}">{{ category.title }}</option>
							</select>
						</div>
						<div class="akeeba__form-group">
							<label for="">Category Icon URL:</label>
							<input type="text" placeholder="Enter image URL" ng-model="category.active.icon_url" ng-disabled="category.active === undefined">
						</div>
						<button class="akeeba__form-group-btn-save" type="button"
							ng-click="category.saveCategoryInfo()"
							ng-disabled="category.active === undefined"
							ng-class="{ disabled: category.active === undefined }">
							<span class="icon-apply icon-white"></span> 
							Save
						</button>
					</div>
				</div>
			</fieldset>
		</div>

	<div class="span4 akeeba__form" ng-controller="ItemCustomsCtrl as itemCtrl">
		<form>
			<legend class="akeeba__form-legend"><abbr title="Akeeba Release System">ARS</abbr> Application Custom Information</legend>
			<fieldset>
				<div class="akeeba__form-group">
					<label for="akeeba_items">Application:</label>
					<div class="akeeba__form-group-mimic-input">
						<select class="form-control" id="akeeba_items"
							ng-options="item.title for item in itemCtrl.items track by item.id"
							ng-model="itemCtrl.activeItem"
							ng-change="itemCtrl.changeActiveItem()"
							></select>
					</div>
				</div>

				<p class="akeeba__form-group-helper-text">Any information <strong>below</strong> will be saved under the selected application <strong>above</strong>.</p>

				<div class="akeeba__form-group">
					<label for="itemIcon">Image Source Link:</label>
					<input id="itemIcon" type="text" placeholder="Enter image source" ng-model="itemCtrl.activeItem.icon_url" ng-disabled="itemCtrl.activeItem == undefined">
				</div>

				<div class="akeeba__form-group">
					<label for="description">Full Name:</label>
					<input id="description" type="text" placeholder="Enter full name" ng-model="itemCtrl.activeItem.short_description" ng-disabled="itemCtrl.activeItem == undefined">
				</div>

				<div class="akeeba__form-group">
					<label for="mainDiscussion">Main Discussion Link:</label>
					<input id="mainDiscussion" type="text" placeholder="Enter main discussion link" ng-model="itemCtrl.activeItem.discussion_url" ng-disabled="itemCtrl.activeItem == undefined">
				</div>

				<div class="akeeba__form-group">
					<label for="issuesDiscussion">Issues Discussion Link:</label>
					<input id="issuesDiscussion" type="text" placeholder="Enter issues discussion link" ng-model="itemCtrl.activeItem.issues_url" ng-disabled="itemCtrl.activeItem == undefined">
				</div>

				<div class="akeeba__form-group">
					<label for="keywords">Keywords:</label>
					<input type="text" id="arsKeywords" placeholder="Enter keywords" ng-model="itemCtrl.activeItem.keywords" ng-disabled="itemCtrl.activeItem == undefined">
				</div>

				<button class="akeeba__form-group-btn-save" type="button"
					ng-click="itemCtrl.saveItemCustoms( itemCtrl.activeItem )"
					ng-disabled="itemCtrl.activeItem == undefined"
					ng-class="{ disabled: itemCtrl.activeItem == undefined }">
					<span class="icon-apply icon-white"></span> 
					Save
				</button>

				<span ng-controller="ParseButton as parseBtn">
					<button id="akeebaRepair" class="akeeba__form-group-btn-danger" type="button" ng-click="parseBtn.parseKeywords()">
						<span class="icon-cogs icon-white"></span> 
						Parse Keywords
					</button>
				</span>

			</fieldset>
		</form>
	</div>

	<div class="span4 akeeba__form" ng-controller="DocumentationsCtrl as docs">
		<form>
			<legend class="akeeba__form-legend"><abbr title="Akeeba Release System">ARS</abbr> Application Documentations</legend>
			<fieldset>
				<p class="help-block">Any information below will be saved under the selected application.</p>
				<p class="help-block"><em>(Documentation Link and Documentation Text should be filled in or none will be saved)</em></p>
				<button class="akeeba__form-group-btn-info" ng-click="docs.addDocumentation()">
					<span class="icon-plus"></span>
					Add Documentation
				</button>
				<button class="akeeba__form-group-btn-save" type="button"
					ng-click="docs.saveDocumentations( $event )">
					<span class="icon-apply icon-white"></span> 
					Save
				</button>
				<ol id="appDocumentation">
					<li ng-repeat="documentation in docs.documentations">
						<div class="akeeba__form-group">
							<button type="button" class="akeeba__documentation-btn-delete pull-right" ng-click="docs.removeDocumentation( $event, documentation.id, documentation.$$hashKey )">
								<span class="icon-trash"></span>
							</button>
							<label for="docLink">Documentation Link:</label>
							<input class="docLink" type="text" placeholder="Enter documentaion link" ng-model="documentation.link" required="required">
						</div>
						<div class="akeeba__form-group">
							<label for="docText">Documentation Text:</label>
							<input class="docText" type="text" placeholder="Enter documentation text" ng-model="documentation.text" required="required">
						</div>
					</li>
				</ol>
			</fieldset>
		</form>
	</div>

</div>