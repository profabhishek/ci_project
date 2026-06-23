CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	//config.language = 'es';
	//config.uiColor = '#aabbcc';
	var path = 'http://205.147.98.190/a2a/';
	config.filebrowserBrowseUrl 			= 		path + '/assets/site/main/js/kcfinder/browse.php?type=files';
	config.filebrowserImageBrowseUrl 		= 		path + '/assets/site/main/js/kcfinder/browse.php?type=images';
	
	config.filebrowserUploadUrl 			= 		path + '/assets/site/main/js/kcfinder/upload.php?type=files';
	config.filebrowserImageUploadUrl 		= 		path + '/assets/site/main/js/kcfinder/upload.php?type=images';
	
	
	
  /*config.filebrowserBrowseUrl 			= 		'http://118.139.161.84/Sortinoresidetial/js/kcfinder/browse.php?type=files';
	config.filebrowserImageBrowseUrl 		= 		'http://118.139.161.84/Sortinoresidetial/js/kcfinder/browse.php?type=images';
	config.filebrowserFlashBrowseUrl 		= 		'http://118.139.161.84/Sortinoresidetial/js/kcfinder/browse.php?type=flash';
	config.filebrowserUploadUrl 			= 		'http://118.139.161.84/Sortinoresidetial/js/kcfinder/upload.php?type=files';
	config.filebrowserImageUploadUrl 		= 		'http://118.139.161.84/Sortinoresidetial/js/kcfinder/upload.php?type=images';
	config.filebrowserFlashUploadUrl 		= 		'http://118.139.161.84/Sortinoresidetial/js/kcfinder/upload.php?type=flash';*/
	/*config.extraPlugins = 'photo,video,customlink,anchorlink';
	config.toolbar_MyToolbarSet =
	[
		['Source'],['Cut','Copy','Paste'],['Undo','Redo'],['Link'],['PageBreak','SpecialChar'],,['TextColor','Image','Table'],'/',['Bold','Italic','Underline','Subscript','Superscript','NumberedList','BulletedList','Outdent','Indent','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','Font','FontSize']
	];
	config.toolbar = 'MyToolbarSet';*/
};
/*CKEDITOR.on('dialogDefinition', function( ev ){	var dialogName = ev.data.name;	var dialogDefinition = ev.data.definition;	if ( dialogName == 'link' )	{		dialogDefinition.minHeight = '100';		dialogDefinition.removeContents( 'advanced' );		var infoTab = dialogDefinition.getContents( 'info' );		infoTab.remove('linkType');		infoTab.remove('browse');		var targetTab = dialogDefinition.getContents( 'target' );		var targetField = targetTab.get('linkTargetType');		targetField.items = [["<No definido>", "notSet"], ["Externo (_blank)", "_blank"], ["Interno (_self)", "_self"]];	}});*/
