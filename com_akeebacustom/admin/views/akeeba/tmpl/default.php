



<div class="row-fluid">

	<div class="span4">

		<form id="akeebaCustom">
			<fieldset>
				<legend>Akeeba Category Custom Information</legend>
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
			</fieldset>
		</form>
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

<script src="components/com_akeebacustom/scripts/akeeba.service.js"></script>
<script>
	;(function(window, document, $, AkeebaService, undefined) {
		$(function() {
			// instantiate our service
			var akeeba = new AkeebaService();
			// get information and applications under selected category
			$('#akeebaCategories').change( function( evnt ) {
				evnt.preventDefault();
				akeeba.getApplications()
				.then(akeeba.getApplicationInfo)
				.then(akeeba.getApplicationDocs);
				akeeba.getInformation();
			});
			// get information for selected application
			$('#akeebaApplications').change( function( evnt ) {
				evnt.preventDefault();
				akeeba.getApplicationInfo();
				akeeba.getApplicationDocs();
			})
			// save information given for selected category
			$('#akeebaSave').click(function( evnt ) {
				evnt.preventDefault();
				var data = {
					categoryId: parseInt($('#akeebaCategories option:selected').val()),
					iconUrl: $('#categoryIcon').val()
				}
				akeeba.saveCategoryInfo( data ).then( function( response ) {
					if( response ) alert('Category Icon for ' + $('#akeebaCategories option:selected').text() + ' is saved.');
				})
			});
			// save information given for selected application
			$('#akeebaItemSave').click(function( evnt ) {
				evnt.preventDefault();
				var data = {
					itemId: $('#akeebaApplications option:selected').val(),
					iconUrl: $('#itemIcon').val(),
					shortDescription: $('#description').val(),
					mainDiscussion: $('#mainDiscussion').val(),
					issuesDiscussion: $('#issuesDiscussion').val()
				}
				if( ! isNaN(data.itemId) ) {
					akeeba.saveApplicationInfo( data ).done( function( response ) {
						response = response.replace(/\s/g, '');
						if( response ) alert('Application Information for ' + $('#akeebaApplications option:selected').text() + ' is saved.');
					})
				} else {
					alert('Error: No valid application selected.');
				}
			});
			// save documentations for selected application
			$('#akeebaDocSave').click( function( evnt ) {
				evnt.preventDefault();
				var docs = $('#appDocumentation li');
				var data = {
					itemId: $('#akeebaApplications option:selected').val(),
					links: []
				}
				if( ! isNaN( data.itemId ) ) {
					$.each(docs, function( index, doc ) {
						data.links.push({
							link: $(doc).find('.docLink').val(),
							text: $(doc).find('.docText').val()
						})
					});
					akeeba.saveApplicationDocs( data ).done( function( response ) {
						response.replace(/\s/g, '');
						if( response ) alert('Documentation for ' + $('#akeebaApplications option:selected').text() + ' is saved.');
					})
				} else {
					alert('Error: No valid application selected.');
				}
			})

		})
	})(window, document, jQuery, AkeebaService);
</script>