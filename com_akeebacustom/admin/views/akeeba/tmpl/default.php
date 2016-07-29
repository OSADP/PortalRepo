
<?php
	// JHTML::stylesheet('administrator/components/com_akeebacustom/styles/keywords.css');
	JHTML::script('administrator/components/com_akeebacustom/scripts/akeeba.custom.min.js');
?>


<div class="row-fluid">

	<div class="span4">

		<form id="akeebaCustom">
			<fieldset>
				<!-- <legend>Akeeba Category Custom Information</legend> -->
				<h2>Akeeba Category:</h2>
				<div class="well">
					<label for="akeebaCategories">Akeeba Categories:</label>
					<select class="form-control" name="category" id="akeebaCategories">
						<option selected="selected" value="0">All Applications</option>
						<?php
						foreach ($this->akeebaCategories as $index => $category ) {
							// if( $index == 0 ) {
							// 	echo '<option selected="selected" value="' . $category->id . '">' . $category->title . '</option>';
							// } else {
								echo '<option value="' . $category->id . '">' . $category->title . '</option>';
							// }
						}
						?>
					</select>

					<br>
					<br>
					<span class="help-block">Any information below will be saved under the selected category.</span>
					<br>
					<label for="fullName">Category Icon URL:</label>
					<input id="categoryIcon" type="text" placeholder="Enter image URL">
					<br>
					<br>
					<button id="akeebaSave" class="btn btn-small btn-success" type="button">
						<span class="icon-apply icon-white"></span> 
						Save
					</button>
				</div>
			</fieldset>
		</form>
		<div class="well" ng-app="AkeebaCustomModule">
			<h3>Akeeba Category</h3>
			<div ng-controller="CategoryCustomsCtrl as category">
				<select ng-model="category.select" ng-init="category.select = 'all'" ng-change="category.changeActive(category)">
					<option value="all">All Applications</option>
					<option ng-repeat="category in category.categories" value="{{ category.id }}">{{ category.title }}</option>
				</select>
				<div style="width: 128px; height: 128px;" ng-if="category.active.icon_url">
					<img ng-src="{{ category.active.icon_url || '' }}" alt="">
				</div>
				<label for="">Category Icon URL:</label>
				<input type="text" ng-model="category.active.icon_url" placeholder="Enter image URL">
			</div>
		</div>
	</div>

	<div class="span4">
		<form>
			<fieldset>
				<legend>Akeeba Application Custom Information</legend>
				<label for="akeebaApplications">Akeeba Applications:</label>
				<select class="form-control" name="applications" id="akeebaApplications"></select>
				<br>
				<br>
				<span class="help-block">Any information below will be saved under the selected application.</span>
				<br>
				<label for="itemIcon">Image Source Link:</label>
				<input id="itemIcon" type="text" placeholder="Enter image source">
				
				<label for="description">Full Name:</label>
				<input id="description" type="text" placeholder="Enter full name">

				<label for="mainDiscussion">Main Discussion Link:</label>
				<input id="mainDiscussion" type="text" placeholder="Enter main discussion link">
				
				<label for="issuesDiscussion">Issues Discussion Link:</label>
				<input id="issuesDiscussion" type="text" placeholder="Enter issues discussion link">

				<!-- Keyword tags -->
				<label for="keywords"><strong>Keywords:</strong></label>
				<div id="arsKeywords">
			    <input type="text" value="" placeholder="Add a keyword" />
			  </div>
				
				<br>
				<br>
				<button id="akeebaItemSave" class="btn btn-small btn-success" type="button">
					<span class="icon-apply icon-white"></span> 
					Save
				</button>
			</fieldset>
		</form>
	</div>

	<div class="span4">
		<form>
			<fieldset>
				<legend>Akeeba Application Documentations</legend>
				<span class="help-block">Any information below will be saved under the selected application.</span>
				<br>

				<ol id="appDocumentation">
					<li>
					<label for="docLink">Documentation Link:</label>
					<input class="docLink" type="text" placeholder="Enter documentaion link">
					<label for="docText">Documentation Text:</label>
					<input class="docText" type="text" placeholder="Enter documentation text">
					<hr>
					</li>
					<li>
					<label for="docLink">Documentation Link:</label>
					<input class="docLink" type="text" placeholder="Enter documentaion link">
					<label for="docText">Documentation Text:</label>
					<input class="docText" type="text" placeholder="Enter documentation text">
					<hr>
					</li>
					<li>
					<label for="docLink">Documentation Link:</label>
					<input class="docLink" type="text" placeholder="Enter documentaion link">
					<label for="docText">Documentation Text:</label>
					<input class="docText" type="text" placeholder="Enter documentation text">
					<hr>
					</li>
					<li>
					<label for="docLink">Documentation Link:</label>
					<input class="docLink" type="text" placeholder="Enter documentaion link">
					<label for="docText">Documentation Text:</label>
					<input class="docText" type="text" placeholder="Enter documentation text">
					<hr>
					</li>
					<li>
					<label for="docLink">Documentation Link:</label>
					<input class="docLink" type="text" placeholder="Enter documentaion link">
					<label for="docText">Documentation Text:</label>
					<input class="docText" type="text" placeholder="Enter documentation text">
					<hr>
					</li>
					<li>
					<label for="docLink">Documentation Link:</label>
					<input class="docLink" type="text" placeholder="Enter documentaion link">
					<label for="docText">Documentation Text:</label>
					<input class="docText" type="text" placeholder="Enter documentation text">
					<hr>
					</li>
					<li>
					<label for="docLink">Documentation Link:</label>
					<input class="docLink" type="text" placeholder="Enter documentaion link">
					<label for="docText">Documentation Text:</label>
					<input class="docText" type="text" placeholder="Enter documentation text">
					<hr>
					</li>
					<li>
					<label for="docLink">Documentation Link:</label>
					<input class="docLink" type="text" placeholder="Enter documentaion link">
					<label for="docText">Documentation Text:</label>
					<input class="docText" type="text" placeholder="Enter documentation text">
					<hr>
					</li>
				</ol>

				<br>
				<button id="akeebaDocSave" class="btn btn-small btn-success" type="button">
					<span class="icon-apply icon-white"></span> 
					Save
				</button>
			</fieldset>
		</form>
	</div>

</div>

<script type="text/template" id="documentationTemplate">
	<li>
		<label for="docLink">Documentation Link:</label>
		<input class="docLink" type="text" placeholder="Enter documentaion link">
		<label for="docText">Documentation Text:</label>
		<input class="docText" type="text" placeholder="Enter documentation text">
		<hr>
	</li>
</script>