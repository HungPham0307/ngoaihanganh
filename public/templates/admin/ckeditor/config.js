/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	config.filebrowserBrowseUrl = '/templates/admin/ckfinder/ckfinder.html';
   config.filebrowserImageBrowseUrl = '/templates/admin/ckfinder/ckfinder.html?type=Images';
   config.filebrowserFlashBrowseUrl = '/templates/admin/ckfinder/ckfinder.html?type=Flash';
   config.filebrowserUploadUrl = '/templates/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
   config.filebrowserImageUploadUrl = '/templates/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
   config.filebrowserFlashUploadUrl = '/templates/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
	
};

