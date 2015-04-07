CKEDITOR.addTemplates( 'default',
{
	// The name of sub folder which hold the shortcut preview images of the templates.
	imagesPath : CKEDITOR.getUrl( CKEDITOR.plugins.getPath( 'templates' ) + 'templates/images/' ),

	// The templates definitions.
	templates :
		[
			{
				title: '2 kolumny',
				//image: 'template1.gif',
				//description: 'Description of my template 1.',
				html:
				    '<table class="template" cellspacing="0" style="width: 100%;"><tr>' +
				        '<td class="t_2_1">' +
					        '<h2>Tytuł 1</h2>' +
					        '<p>Treść 1</p>' +
					    '</td>' +
				        '<td class="separator">&nbsp;</td>' +
				        '<td class="t_2_2">' +
					        '<h2>Tytuł 2</h2>' +
					        '<p>Treść 2</p>' +
					    '</td>' +
					'</tr></table>'
			},
			{
				title: '3 kolumny',
				html:
				    '<table class="template" cellspacing="0" style="width: 100%;"><tr>' +
				        '<td class="t_3_1">' +
					        '<h2>Tytuł 1</h2>' +
					        '<p>Treść 1</p>' +
					    '</td>' +
				        '<td class="separator">&nbsp;</td>' +
				        '<td class="t_3_2">' +
					        '<h2>Tytuł 2</h2>' +
					        '<p>Treść 2</p>' +
					    '</td>' +
				        '<td class="separator">&nbsp;</td>' +
				        '<td class="t_3_3">' +
					        '<h2>Tytuł 3</h2>' +
					        '<p>Treść 3</p>' +
					    '</td>' +
					'</tr></table>'
			}
		]
});
